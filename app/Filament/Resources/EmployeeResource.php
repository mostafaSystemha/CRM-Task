<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
// use App\Models\customer;

use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\ImageColumn;
class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;
    protected static ?string $navigationGroup = "Employee Settings";
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('English Details')->schema([
                TextInput::make('name')->required()->label('English Name'),
                MarkdownEditor::make('address_en')->label('English Address'),
            ])->columnSpan(2),
            Group::make()->schema([

                Section::make("Status")->schema([
                    Toggle::make('isAdmin')
                    ->label('Is Admin')
                    ->unique(User::class, 'isAdmin', ignoreRecord: true)
                    ->default(false)
                ])->columnSpan(1),
                Section::make("General Details")->schema([
                    TextInput::make('zipCode')->label('Zip Code'),
                    DatePicker::make('date_of_birth')
                        ->native(false)
                        ->displayFormat('d/m/Y')
                        ->required(),
                    DatePicker::make('date_hired')
                        ->label('Hired Date')
                        ->native(false)
                        ->displayFormat('d/m/Y')
                        ->required(),
                ])->columnSpan(1),
            ]),
            Section::make('Arabic Details')->schema([
                TextInput::make('name_ar')->label('Arabic Name'),
                MarkdownEditor::make('address_ar')->label('Arabic Address'),
            ])->columnSpan(2),
            Group::make()->schema([
                Section::make("Account Details")->schema([
                    TextInput::make('email')
                        ->label('Email address')
                        ->required()
                        ->maxLength(255)
                        ->email()
                        ->unique(User::class, 'email', ignoreRecord: true),
                    TextInput::make('password')
                        ->password()
                        ->required()
                        ->revealable()
                        // ->copyable()
                        // ->generatable()
                        // ->rules($this->passwordRules())
                        // ->dehydrateStateUsing(static fn (string $state): string => Hash::make($state))
                        ->same('passwordConfirmation'),
                    TextInput::make('passwordConfirmation')
                        ->password()
                        ->required()
                        ->revealable()
                        ->dehydrated(false),
                ])->columnSpan(1),
                // Section::make("Assign Customer")->schema([
                //     Select::make('id')
                //     ->relationship(name: 'customer', titleAttribute: 'name_en')
                //     ->label('Customer')
                //     ->searchable()
                //     ->preload()
                // ]),
            ]),
            Section::make("Image")->schema([
                FileUpload::make("image")->label('')->disk('public')->directory('customerImages'),
            ])->columnSpan(2),

        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->circular(),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('description')->sortable()->searchable(),
                TextColumn::make('status')->badge()->sortable()->searchable()
                ->color(fn (string $state): string => match ($state) {
                    '1' => 'success',
                    '0' => 'danger',
                })
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
