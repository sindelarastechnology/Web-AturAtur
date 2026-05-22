<?php

namespace App\Filament\Client\Resources;

use App\Filament\Client\Resources\InvitationResource\Pages;
use App\Models\Invitation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InvitationResource extends Resource
{
    protected static ?string $model = Invitation::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $recordTitleAttribute = 'title';

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('user_id', auth()->id())->count();
        return $count ?: null;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        $user = auth()->user();

        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Undangan')
                    ->schema([
                        Forms\Components\Hidden::make('user_id')
                            ->default(fn() => auth()->id()),
                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(150)
                            ->placeholder('cth: Undangan Pernikahan Iskandar & Uning'),
                        Forms\Components\TextInput::make('slug')
                            ->label('Link Undangan')
                            ->required()
                            ->maxLength(100)
                            ->readOnly()
                            ->helperText('URL undangan Anda. Tidak bisa diubah.'),
                        Forms\Components\Select::make('theme_id')
                            ->label('Tema')
                            ->relationship('theme', 'name', fn(Builder $query) => $query->where('is_active', true))
                            ->default(auth()->user()->theme_id)
                            ->disabled()
                            ->helperText('Tema ditentukan oleh admin. Tidak bisa diubah.'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->required()
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('Mempelai Pria')
                    ->schema([
                        Forms\Components\TextInput::make('groom_name')
                            ->label('Nama Lengkap')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('groom_nickname')
                            ->label('Nama Panggilan')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('groom_father')
                            ->label('Nama Ayah')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('groom_mother')
                            ->label('Nama Ibu')
                            ->maxLength(100),
                        Forms\Components\FileUpload::make('groom_photo')
                            ->label('Foto')
                            ->image()
                            ->directory('invitations')
                            ->visibility('public'),
                    ])->columns(2),

                Forms\Components\Section::make('Mempelai Wanita')
                    ->schema([
                        Forms\Components\TextInput::make('bride_name')
                            ->label('Nama Lengkap')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('bride_nickname')
                            ->label('Nama Panggilan')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('bride_father')
                            ->label('Nama Ayah')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('bride_mother')
                            ->label('Nama Ibu')
                            ->maxLength(100),
                        Forms\Components\FileUpload::make('bride_photo')
                            ->label('Foto')
                            ->image()
                            ->directory('invitations')
                            ->visibility('public'),
                    ])->columns(2),

                Forms\Components\Section::make('Konten')
                    ->schema([
                        Forms\Components\FileUpload::make('cover_photo')
                            ->label('Foto Cover')
                            ->image()
                            ->directory('invitations')
                            ->visibility('public'),
                        Forms\Components\Textarea::make('opening_quote')
                            ->label('Kutipan Pembuka')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('love_story')
                            ->label('Cerita Cinta')
                            ->rows(5)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('music_url')
                            ->label('URL Musik (YouTube)')
                            ->maxLength(255)
                            ->placeholder('https://youtube.com/watch?v=...')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Amplop Digital')
                    ->schema([
                        Forms\Components\TextInput::make('bank_name')
                            ->label('Nama Bank')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('bank_account')
                            ->label('No. Rekening')
                            ->maxLength(50),
                    ])->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('url')
                    ->label('Link')
                    ->getStateUsing(fn(Invitation $record) => url("/{$record->slug}"))
                    ->copyable()
                    ->copyMessage('Link copied!')
                    ->formatStateUsing(fn($state) => $state),
                Tables\Columns\TextColumn::make('theme.name')
                    ->label('Tema')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('view_count')
                    ->label('Dilihat')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
                Tables\Filters\SelectFilter::make('theme_id')
                    ->label('Tema')
                    ->relationship('theme', 'name'),
            ])
            ->actions([
                Tables\Actions\Action::make('preview')
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->url(fn(Invitation $record) => "/{$record->slug}")
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListInvitations::route('/'),
            'edit' => Pages\EditInvitation::route('/{record}/edit'),
        ];
    }
}
