<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Club;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\ClubResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ClubResource\RelationManagers;

class ClubResource extends Resource
{
   protected static ?string $model = Club::class;
   protected static ?string $navigationIcon = 'heroicon-o-building-office';
   protected static ?string $navigationGroup = 'Management';
   protected static ?int $navigationSort = 1;

   public static function form(Form $form): Form
   {
       return $form
           ->schema([
               Forms\Components\Section::make()
                   ->schema([
                       Forms\Components\TextInput::make('name')
                           ->required()
                           ->maxLength(255),
                       Forms\Components\TextInput::make('email')
                           ->email()
                           ->required(),
                       Forms\Components\TextInput::make('phone')
                           ->tel(),
                       Forms\Components\TextInput::make('address'),
                       Forms\Components\TextInput::make('cif'),
                       
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
               Tables\Columns\TextColumn::make('members_count')
                   ->label('Members')
                   ->counts('members')
                   ->sortable(),
               Tables\Columns\TextColumn::make('created_at')
                   ->dateTime()
                   ->sortable(),
           ])
           ->filters([
               Tables\Filters\SelectFilter::make('is_active')
                   ->options([
                       '1' => 'Active',
                       '0' => 'Inactive',
                   ]),
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
            'index' => Pages\ListClubs::route('/'),
            'create' => Pages\CreateClub::route('/create'),
            'edit' => Pages\EditClub::route('/{record}/edit'),
        ];
    }
}
