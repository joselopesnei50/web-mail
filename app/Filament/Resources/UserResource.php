<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Usuários';
    protected static ?string $modelLabel = 'Usuário';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nome')
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->label('E-mail')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->helperText('Este email tambem sera a conta no servidor (login IMAP/SMTP).'),
                    Forms\Components\TextInput::make('password')
                        ->label('Senha')
                        ->password()
                        ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                        ->minLength(8)
                        ->helperText('Ao criar/alterar, a mesma senha e aplicada no servidor de email.')
                        ->dehydrated(fn ($state) => filled($state)),
                    Forms\Components\Select::make('company_id')
                        ->label('Empresa (Workspace)')
                        ->relationship('company', 'name')
                        ->required(),
                    Forms\Components\Select::make('role')
                        ->label('Cargo')
                        ->options([
                            'user' => 'Usuário Comum',
                            'admin' => 'Administrador (Workspace)',
                            'super_admin' => 'Super Administrador (Global)',
                        ])
                        ->required()
                        ->default('user'),
                    Forms\Components\Toggle::make('create_mailbox')
                        ->label('Criar conta no servidor de email')
                        ->helperText('Cria a caixa no docker-mailserver. Desmarcar se o email e externo.')
                        ->default(true)
                        ->dehydrated(false)
                        ->visible(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->label('Nome'),
                Tables\Columns\TextColumn::make('email')->searchable()->label('E-mail'),
                Tables\Columns\TextColumn::make('company.name')->label('Empresa')->searchable(),
                Tables\Columns\BadgeColumn::make('role')
                    ->label('Cargo')
                    ->colors([
                        'primary' => 'user',
                        'warning' => 'admin',
                        'danger' => 'super_admin',
                    ]),
                Tables\Columns\IconColumn::make('has_mailbox')
                    ->label('Caixa')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d/m/Y')->label('Criado em'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
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
