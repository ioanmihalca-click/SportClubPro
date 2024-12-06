<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $modelLabel = 'Utilizator';
    protected static ?string $pluralModelLabel = 'Utilizatori';

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
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('password')
                            ->label('Parolă')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create'),
                            
                        Forms\Components\Select::make('club_id')
                            ->label('Club')
                            ->relationship('club', 'name')
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
                    // Numele Utilizatorului
                    Tables\Columns\TextColumn::make('name')
                        ->color('primary')
                        ->weight(FontWeight::Bold)
                        ->searchable()
                        ->sortable(),
                        
                    // Email    
                    Tables\Columns\TextColumn::make('email')
                        ->formatStateUsing(fn ($state) => "Email: {$state}"),
                        
                    // Club    
                    Tables\Columns\TextColumn::make('club.name')
                        ->formatStateUsing(fn ($state) => $state ? "Club: {$state}" : "Fără club"),
                        
                    // Data înregistrării    
                    Tables\Columns\TextColumn::make('created_at')
                        ->dateTime('d/m/Y H:i'),
                ])
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('club')
                    ->label('Club')
                    ->relationship('club', 'name')
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('email', '!=', 'contact@sportclubpro.ro');
    }
}