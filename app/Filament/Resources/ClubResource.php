<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClubResource\Pages;
use App\Models\Club;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;

class ClubResource extends Resource
{
    protected static ?string $model = Club::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    
    protected static ?string $modelLabel = 'Club';
    protected static ?string $pluralModelLabel = 'Cluburi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nume')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('phone')
                            ->label('Telefon')
                            ->tel()
                            ->maxLength(255),
                            
                        Forms\Components\Select::make('users')
                            ->label('Administrator')
                            ->relationship('users', 'name')
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    // Numele Clubului
                    Tables\Columns\TextColumn::make('name')
                        ->color('primary')
                        ->weight(FontWeight::Bold)
                        ->searchable()
                        ->sortable(),
                        
                    // Membri
                    Tables\Columns\TextColumn::make('members_count')
                        ->formatStateUsing(fn ($state) => "Membri: {$state}")
                        ->counts('members'),
                        
                    // Administrator    
                    Tables\Columns\TextColumn::make('users.name')
                        ->formatStateUsing(fn ($state) => "Administrator: {$state}"),
                        
                    // Data înregistrării    
                    Tables\Columns\TextColumn::make('created_at')
                        ->dateTime('d/m/Y H:i'),
                ])
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user')
                    ->label('Administrator')
                    ->relationship('users', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordClasses('space-y-2');
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClubs::route('/'),
            'create' => Pages\CreateClub::route('/create'),
            'edit' => Pages\EditClub::route('/{record}/edit'),
        ];
    }
}