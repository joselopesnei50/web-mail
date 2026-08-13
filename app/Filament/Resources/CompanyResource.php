<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-office-building';
    protected static ?string $navigationLabel = 'Empresas (Workspaces)';
    protected static ?string $modelLabel = 'Empresa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nome da Empresa')
                        ->required(),
                    Forms\Components\TextInput::make('domain')
                        ->label('Domínio')
                        ->required()
                        ->unique(ignoreRecord: true),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Ativo')
                        ->default(true),
                ])->columns(2),
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('max_users')
                        ->label('Límite de Usuários')
                        ->numeric()
                        ->default(5),
                    Forms\Components\TextInput::make('max_emails_month')
                        ->label('Límite de Envios Mensais')
                        ->numeric()
                        ->default(1000),
                    Forms\Components\TextInput::make('storage_limit_mb')
                        ->label('Armazenamento (MB)')
                        ->numeric()
                        ->default(1024),
                ])->columns(3)->heading('Capacidade e Limites'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->label('Nome'),
                Tables\Columns\TextColumn::make('domain')->searchable()->label('Domínio'),
                Tables\Columns\BooleanColumn::make('is_active')->label('Ativo'),
                Tables\Columns\TextColumn::make('max_users')->label('Usuários Máx'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d/m/Y')->label('Criado em'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }    
}
