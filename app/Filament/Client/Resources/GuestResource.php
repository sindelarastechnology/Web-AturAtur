<?php

namespace App\Filament\Client\Resources;

use App\Filament\Client\Resources\GuestResource\Pages;
use App\Models\Guest;
use App\Models\Invitation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class GuestResource extends Resource
{
    protected static ?string $model = Guest::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('invitation', fn(Builder $q) => $q->where('user_id', auth()->id()));
    }

    public static function form(Form $form): Form
    {
        $invitation = Invitation::where('user_id', auth()->id())->first();
        $package = auth()->user()->package;
        $isBasic = $package && $package->slug === 'basic';

        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Hidden::make('invitation_id')
                            ->default($invitation?->id)
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(150)
                            ->reactive()
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),
                        Forms\Components\Hidden::make('slug'),
                        Forms\Components\TextInput::make('phone')
                            ->label('No. Telepon')
                            ->tel()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('group_label')
                            ->label('Grup')
                            ->maxLength(100)
                            ->placeholder('cth: Keluarga, Teman, Rekan Kerja'),
                        Forms\Components\Select::make('rsvp_status')
                            ->label('RSVP')
                            ->required()
                            ->options([
                                'pending' => 'Pending',
                                'hadir' => 'Hadir',
                                'tidak_hadir' => 'Tidak Hadir',
                                'ragu' => 'Ragu',
                            ])
                            ->default('pending'),
                        Forms\Components\TextInput::make('guest_count')
                            ->label('Jumlah Tamu')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->minValue(1),
                    ])->columns(2),

                Forms\Components\Section::make('Gift / Hadiah')
                    ->visible(fn() => !$isBasic)
                    ->schema([
                        Forms\Components\Select::make('gift.type')
                            ->label('Jenis')
                            ->options([
                                'uang' => 'Uang',
                                'barang' => 'Barang',
                            ])
                            ->nullable()
                            ->reactive()
                            ->afterStateUpdated(fn(callable $set) => $set('gift.amount', null)),
                        Forms\Components\TextInput::make('gift.amount')
                            ->label('Jumlah (Rp)')
                            ->numeric()
                            ->minValue(0)
                            ->visible(fn(callable $get) => $get('gift.type') === 'uang'),
                        Forms\Components\Textarea::make('gift.description')
                            ->label('Deskripsi Barang')
                            ->rows(2)
                            ->visible(fn(callable $get) => $get('gift.type') === 'barang'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        $package = auth()->user()->package;
        $isBasic = $package && $package->slug === 'basic';
        $invitation = Invitation::where('user_id', auth()->id())->first();

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('group_label')
                    ->label('Grup')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('rsvp_status')
                    ->label('RSVP')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'hadir',
                        'danger' => 'tidak_hadir',
                        'info' => 'ragu',
                    ]),
                Tables\Columns\TextColumn::make('guest_count')
                    ->label('Jumlah')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gift.type')
                    ->label('Hadiah')
                    ->badge()
                    ->visible(fn() => !$isBasic)
                    ->colors(['success' => 'uang', 'info' => 'barang']),
                Tables\Columns\TextColumn::make('gift.amount')
                    ->label('Jumlah')
                    ->visible(fn($record) => !$isBasic && $record?->gift?->type === 'uang')
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('gift.description')
                    ->label('Keterangan')
                    ->visible(fn($record) => !$isBasic && $record?->gift?->type === 'barang')
                    ->limit(30),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('rsvp_status')
                    ->options([
                        'pending' => 'Pending',
                        'hadir' => 'Hadir',
                        'tidak_hadir' => 'Tidak Hadir',
                        'ragu' => 'Ragu',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('copy_link')
                    ->label('Salin Link')
                    ->icon('heroicon-o-clipboard')
                    ->color('gray')
                    ->modalHeading('Link Undangan')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalContent(function (Guest $record) use ($invitation) {
                        $link = $invitation
                            ? url("/{$invitation->slug}/{$record->slug}")
                            : url('/');
                        return new \Illuminate\Support\HtmlString('
                            <div x-data="{ copied: false }" style="display:flex;gap:0.5rem;align-items:stretch;">
                                <input type="text" x-ref="linkInput" value="' . e($link) . '"
                                    style="flex:1;padding:0.5rem 0.75rem;border:1px solid #d1d5db;border-radius:0.5rem;font-size:0.875rem;"
                                    readonly @click="$refs.linkInput.select()" />
                                <button @click="navigator.clipboard.writeText($refs.linkInput.value).then(() => { copied = true; setTimeout(() => copied = false, 2000); })"
                                    style="padding:0.5rem 1rem;background:#8B1A4A;color:white;border:none;border-radius:0.5rem;cursor:pointer;font-weight:600;white-space:nowrap;">
                                    <span x-show="!copied">Salin</span>
                                    <span x-show="copied" style="color:#a0f0a0;">Tersalin!</span>
                                </button>
                            </div>
                        ');
                    }),
                Tables\Actions\Action::make('share_wa')
                    ->label('Bagikan WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->color('success')
                    ->url(function (Guest $record) use ($invitation) {
                        if (!$invitation) return '#';
                        $link = url("/{$invitation->slug}/{$record->slug}");
                        $groomName = $invitation->groom_name ?? 'Mempelai Pria';
                        $brideName = $invitation->bride_name ?? 'Mempelai Wanita';
                        $groomNick = $invitation->groom_nickname ?? $invitation->groom_name ?? 'Mempelai Pria';
                        $brideNick = $invitation->bride_nickname ?? $invitation->bride_name ?? 'Mempelai Wanita';

                        $text = "Kepada Yth.\n{$record->name}\n__________\n\nAssalamualaikum Wr. Wb.\n\nBismillahirahmanirrahim.\nTanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i, teman sekaligus sahabat, untuk menghadiri acara pernikahan kami:\n\n{$groomName}\n&\n{$brideName}\n\nBerikut link untuk info lengkap dari acara kami :\n{$link}\n\nMerupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.\n\nTerima Kasih..\n\nWassalamualaikum Wr. Wb.\n\nHormat kami,\n{$groomNick} & {$brideNick}";

                        $phone = $record->phone ? preg_replace('/[^0-9]/', '', $record->phone) : '';
                        if ($phone && str_starts_with($phone, '0')) {
                            $phone = '62' . substr($phone, 1);
                        }

                        return 'https://wa.me/' . $phone . '?text=' . urlencode($text);
                    })
                    ->openUrlInNewTab()
                    ->visible(fn(Guest $record) => !empty($record->phone)),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->header(function () use ($invitation) {
                $total = $invitation?->guests()->count() ?? 0;
                $hadir = $invitation?->guests()->where('rsvp_status', 'hadir')->count() ?? 0;
                $tidakHadir = $invitation?->guests()->where('rsvp_status', 'tidak_hadir')->count() ?? 0;
                $pending = $invitation?->guests()->where('rsvp_status', 'pending')->count() ?? 0;
                return new HtmlString('
                    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:0.75rem;margin-bottom:1rem;">
                        <div style="background:#f8f6f0;border-radius:0.75rem;padding:1rem;text-align:center;">
                            <div style="font-size:1.5rem;font-weight:700;color:#1a1a2e;">' . $total . '</div>
                            <div style="font-size:0.75rem;color:#888;margin-top:0.25rem;">Total Tamu</div>
                        </div>
                        <div style="background:#f0faf0;border-radius:0.75rem;padding:1rem;text-align:center;">
                            <div style="font-size:1.5rem;font-weight:700;color:#2d6a2d;">' . $hadir . '</div>
                            <div style="font-size:0.75rem;color:#888;margin-top:0.25rem;">Hadir</div>
                        </div>
                        <div style="background:#fef0f0;border-radius:0.75rem;padding:1rem;text-align:center;">
                            <div style="font-size:1.5rem;font-weight:700;color:#a02020;">' . $tidakHadir . '</div>
                            <div style="font-size:0.75rem;color:#888;margin-top:0.25rem;">Tidak Hadir</div>
                        </div>
                        <div style="background:#fef8e8;border-radius:0.75rem;padding:1rem;text-align:center;">
                            <div style="font-size:1.5rem;font-weight:700;color:#b8860b;">' . $pending . '</div>
                            <div style="font-size:0.75rem;color:#888;margin-top:0.25rem;">Pending</div>
                        </div>
                    </div>
                ');
            })
            ->headerActions([
                Tables\Actions\Action::make('export_csv')
                    ->label('Export CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('gray')
                    ->url(function () use ($invitation) {
                        if (!$invitation) return '#';
                        return route('guests.export', ['invitation' => $invitation->id]);
                    })
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('import_csv')
                    ->label('Import CSV')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('gray')
                    ->form([
                        Forms\Components\FileUpload::make('csv_file')
                            ->label('File CSV')
                            ->acceptedFileTypes(['text/csv', 'text/plain', 'application/csv'])
                            ->maxSize(1024)
                            ->required()
                            ->helperText('Format: Nama, Telepon, Grup. Baris pertama adalah header dan akan dilewati.'),
                    ])
                    ->action(function (array $data) use ($invitation) {
                        if (!$invitation) return;
                        $file = $data['csv_file'];
                        $path = storage_path('app/public/' . $file);
                        if (!file_exists($path)) return;
                        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                        if (!$lines) return;
                        array_shift($lines);
                        $success = 0;
                        $errors = [];
                        foreach ($lines as $i => $line) {
                            $parts = str_getcsv($line);
                            $name = trim($parts[0] ?? '');
                            $phone = trim($parts[1] ?? '');
                            $group = trim($parts[2] ?? '');
                            if (!$name) {
                                $errors[] = 'Baris ' . ($i + 2) . ': Nama kosong';
                                continue;
                            }
                            $slug = Str::slug($name);
                            $origSlug = $slug;
                            $counter = 1;
                            while (Guest::where('invitation_id', $invitation->id)->where('slug', $slug)->exists()) {
                                $slug = $origSlug . '-' . $counter++;
                            }
                            Guest::create([
                                'invitation_id' => $invitation->id,
                                'name' => $name,
                                'slug' => $slug,
                                'phone' => $phone,
                                'group_label' => $group,
                            ]);
                            $success++;
                        }
                        if (file_exists($path)) unlink($path);
                        $msg = "Berhasil import {$success} tamu.";
                        if ($errors) $msg .= ' ' . count($errors) . ' baris gagal: ' . implode('; ', array_slice($errors, 0, 5));
                        Notification::make()->title($msg)->success()->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGuests::route('/'),
            'create' => Pages\CreateGuest::route('/create'),
            'edit' => Pages\EditGuest::route('/{record}/edit'),
        ];
    }
}
