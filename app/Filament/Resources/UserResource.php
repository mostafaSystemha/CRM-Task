<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;



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
class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = "Employee Settings";
    protected static ?string $navigationla = "Employee Settings";
    protected static ?string $modelLabel = "Employee";
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make(__('translations.English_Details'))->schema([
                TextInput::make('name')->required()->label(__('translations.English_Name')),
                MarkdownEditor::make('address_en')->label(__('translations.English_Address')),
            ])->columnSpan(2),
            Group::make()->schema([

                Section::make(__('translations.Status'))->schema([
                    Toggle::make('is_admin')
                    ->label(__('translations.Is_Admin'))
                    // ->unique(User::class, 'is_admin', ignoreRecord: true)
                    ->default(false)
                ])->columnSpan(1),
                Section::make(__('translations.General_Details'))->schema([
                    TextInput::make('zipCode')->label(__('translations.Zip_Code')),
                    DatePicker::make('date_of_birth')
                        ->label(__('translations.Date_Of_Birth'))
                        ->native(false)
                        ->displayFormat('d/m/Y')
                        ->required(),
                    DatePicker::make('date_hired')
                        ->label(__('translations.Hired_Date'))
                        ->native(false)
                        ->displayFormat('d/m/Y')
                        ->required(),
                ])->columnSpan(1),
            ]),
            Section::make(__('translations.Arabic_Details'))->schema([
                TextInput::make('name_ar')->label(__('translations.Arabic_Name')),
                MarkdownEditor::make('address_ar')->label(__('translations.Arabic_Address')),
            ])->columnSpan(2),
            Group::make()->schema([
                Section::make(__('translations.Account_Details'))->schema([
                    TextInput::make('email')
                        ->label(__('translations.Email_address'))
                        ->required()
                        ->maxLength(255)
                        ->email()
                        ->unique(User::class, 'email', ignoreRecord: true),
                    TextInput::make('password')
                        ->label(__('translations.Password'))
                        ->password()
                        ->required()
                        ->revealable()
                        // ->copyable()
                        // ->generatable()
                        // ->rules($this->passwordRules())
                        // ->dehydrateStateUsing(static fn (string $state): string => Hash::make($state))
                        ->same('passwordConfirmation'),
                    TextInput::make('passwordConfirmation')
                        ->label(__('translations.Confirmation_Password'))
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
            Section::make(__('translations.Image'))->schema([
                FileUpload::make("image")->label('')->disk('public')->directory('customerImages'),
            ])->columnSpan(2),

        ])->columns(3);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('translations.Full_Name'))
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('email')
                    ->label(__('translations.Email_address'))
                    ->searchable()
                    ->sortable()
                    ->alignLeft(),
                TextColumn::make(__('translations.created_at'))->searchable()->sortable()->toggleable(),
                TextColumn::make(__('translations.updated_at'))->searchable()->sortable()->toggleable()
            ])
            ->filters([
                //
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
