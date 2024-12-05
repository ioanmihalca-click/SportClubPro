<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
           ->schema([
               Forms\Components\Card::make()
                   ->schema([
                       Forms\Components\TextInput::make('name')
                           ->required()
                           ->maxLength(255),
                       Forms\Components\TextInput::make('email')
                           ->email()
                           ->required()
                           ->unique(ignorable: fn ($record) => $record),
                       Forms\Components\TextInput::make('password')
                           ->password()
                           ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                           ->dehydrated(fn ($state) => filled($state))
                           ->required(fn (string $context): bool => $context === 'create'),
                       Forms\Components\Select::make('club_id')
                           ->relationship('club', 'name')
                           ->searchable()
                           ->preload(),
                      
                   ])
           ]);
   }

   public static function table(Table $table): Table
   {
       return $table
           ->columns([
               Tables\Columns\TextColumn::make('name')
                   ->searchable()
                   ->sortable(),
               Tables\Columns\TextColumn::make('email')
                   ->searchable(),
               Tables\Columns\TextColumn::make('club.name')
                   ->label('Club')
                   ->searchable(),
               Tables\Columns\TextColumn::make('created_at')
                   ->dateTime()
                   ->sortable(),
           ])
           ->filters([
               Tables\Filters\Filter::make('created_at')
                   ->form([
                       Forms\Components\DatePicker::make('created_from'),
                       Forms\Components\DatePicker::make('created_until'),
                   ])
                   ->query(function (Builder $query, array $data): Builder {
                       return $query
                           ->when(
                               $data['created_from'],
                               fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                           )
                           ->when(
                               $data['created_until'],
                               fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                           );
                   })
           ])
           ->actions([
               Tables\Actions\EditAction::make(),
 
              
           ])
           ->bulkActions([
               Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
