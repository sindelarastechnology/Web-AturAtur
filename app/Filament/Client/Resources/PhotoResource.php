<?php

namespace App\Filament\Client\Resources;

use App\Filament\Client\Resources\PhotoResource\Pages;
use App\Models\Photo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PhotoResource extends Resource
{
    protected static ?string $model = Photo::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $recordTitleAttribute = 'original_name';

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
                        Forms\Components\FileUpload::make('filename')
                            ->label('Foto')
                            ->image()
                            ->directory('photos')
                            ->visibility('public')
                            ->required()
                            ->maxSize(5120),
                        Forms\Components\Hidden::make('original_name'),
                        Forms\Components\Hidden::make('size_kb'),
                        Forms\Components\Select::make('type')
                            ->label('Tipe')
                            ->required()
                            ->options([
                                'gallery' => 'Galeri',
                                'prewedding' => 'Prewedding',
                                'ceremony' => 'Acara',
                            ])
                            ->default('gallery'),
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
                Tables\Columns\ImageColumn::make('filename')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(fn($record) => 'https://ui-avatars.com/api/?name=Photo'),
                Tables\Columns\TextColumn::make('invitation.title')
                    ->label('Undangan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('original_name')
                    ->label('Nama File')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge(),
                Tables\Columns\TextColumn::make('size_kb')
                    ->label('Ukuran (KB)')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diupload')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'gallery' => 'Galeri',
                        'prewedding' => 'Prewedding',
                        'ceremony' => 'Acara',
                    ]),
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
            'index' => Pages\ListPhotos::route('/'),
            'create' => Pages\CreatePhoto::route('/create'),
            'edit' => Pages\EditPhoto::route('/{record}/edit'),
        ];
    }
}
