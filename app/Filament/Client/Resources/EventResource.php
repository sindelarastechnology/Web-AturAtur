<?php

namespace App\Filament\Client\Resources;

use App\Filament\Client\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $recordTitleAttribute = 'title';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('invitation', fn(Builder $q) => $q->where('user_id', auth()->id()));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('invitation_id')
                            ->label('Undangan')
                            ->relationship(
                                'invitation',
                                'title',
                                fn(Builder $query) => $query->where('user_id', auth()->id())
                            )
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('type')
                            ->label('Tipe')
                            ->required()
                            ->options([
                                'akad' => 'Akad',
                                'resepsi' => 'Resepsi',
                                'ngunduh_mantu' => 'Ngunduh Mantu',
                                'midodareni' => 'Midodareni',
                                'saresehan' => 'Saresehan',
                            ])
                            ->default('resepsi'),
                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('cth: Resepsi Pernikahan'),
                        Forms\Components\DatePicker::make('date')
                            ->label('Tanggal')
                            ->required()
                            ->displayFormat('d F Y'),
                        Forms\Components\TextInput::make('time_start')
                            ->label('Jam Mulai')
                            ->required()
                            ->placeholder('08:00'),
                        Forms\Components\TextInput::make('time_end')
                            ->label('Jam Selesai')
                            ->placeholder('12:00'),
                        Forms\Components\TextInput::make('venue_name')
                            ->label('Nama Tempat')
                            ->maxLength(150)
                            ->placeholder('cth: Gedung Serbaguna'),
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat')
                            ->rows(3),
                        Forms\Components\TextInput::make('maps_url')
                            ->label('URL Google Maps')
                            ->maxLength(500)
                            ->placeholder('https://maps.google.com/...'),
                        Forms\Components\Textarea::make('maps_embed')
                            ->label('Embed Google Maps')
                            ->rows(4)
                            ->placeholder('<iframe src="..."></iframe>'),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invitation.title')
                    ->label('Undangan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('time_start')
                    ->label('Jam'),
                Tables\Columns\TextColumn::make('venue_name')
                    ->label('Tempat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('date')
            ->filters([
                Tables\Filters\SelectFilter::make('invitation_id')
                    ->label('Undangan')
                    ->relationship('invitation', 'title', fn(Builder $query) => $query->where('user_id', auth()->id())),
            ])
            ->actions([
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
