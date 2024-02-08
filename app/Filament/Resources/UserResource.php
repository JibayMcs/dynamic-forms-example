<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\DummyForm;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use JibayMcs\DynamicForms\Forms\DynamicForm;

class UserResource extends Resource
{

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            //   From Database/Model
            //  ->schema(DynamicForm::make(DummyForm::first(), 'data'));

            //   From JSON File
            //      ->schema(DynamicForm::make(storage_path('forms.json')));

            //   Classic Form
            /*->schema([
                Forms\Components\TextInput::make('test')
                ->live()
            ]);*/

            // Classic Form + Dynamic Form from JSON
            /*->schema([
                Forms\Components\TextInput::make('test'),
                ...DynamicForm::make(storage_path('forms.json'))
            ]);*/

            // Classic Form + Dynamic Form from relation
            ->schema([
                Forms\Components\TextInput::make('test'),

                ...DynamicForm::make("test_form")
                    ->default(storage_path('forms.json'))
                    ->relationship('dummyForm', 'data', $form)
                ->getSchema()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
