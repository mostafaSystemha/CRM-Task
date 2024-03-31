<?php

namespace App\Filament\Employee\Resources;

use App\Filament\Employee\Resources\CustomerResource\Pages;
use App\Filament\Employee\Resources\CustomerResource\RelationManagers;
use App\Models\User;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;



use Illuminate\Support\Carbon;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\ImageColumn;
class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    // protected static ?string $navigationIcon = 'heroicon-o-users';
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('English Details')->schema([
                TextInput::make('name_en')->required()->label('English Name'),
                TextInput::make('email')
                ->label('email')
                ->required()
                ->suffix('@gmail.com'),
                MarkdownEditor::make('address_en')->required()->label('English address'),
            ])->columnSpan(2),
            Group::make()->schema([
                Section::make("Action Status")->schema([
                    Toggle::make('call'),
                    Toggle::make('visit'),
                    Toggle::make('follow-up'),
                    TextInput::make('link')
                    ->prefix('www.')
                    ->suffix('.com'),
                ])->columnSpan(1),
            ]),
            Section::make('Arabic Details')->schema([
                TextInput::make('name_ar')->required()->label('Arabic Name'),
                MarkdownEditor::make('address_ar')->required()->label('Arabic address'),
            ])->columnSpan(2),
            Group::make()->schema([
                Section::make("Assign to Employee")->schema([
                    Select::make('user_id')
                    ->relationship(name: 'User', titleAttribute: 'name')
                    ->label('Employee')
                    ->searchable()
                    ->preload()
                ])->columnSpan(1),
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
                // Select::make('id')
                // ->relationship(name: 'customer', titleAttribute: 'name_en')
                // ->label('Customer')
                // ->searchable()
                // ->preload(),
                // ImageColumn::make('image')->circular()
                // ->label('Customer Image')
                // ->searchable(),
                TextColumn::make('name_ar')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable(),
                ToggleColumn::make('call')
                    ->label('Call Action')
                    ->disabled(),
                ToggleColumn::make('visit')
                    ->label('Visit Action')
                    ->disabled(),
                ToggleColumn::make('follow-up')
                    ->label('FollowUp Action')
                    ->disabled(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

            ])
            ->filters([
                SelectFilter::make('User')
                    ->relationship('User', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Filter by User')
                    ->indicator('User'),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
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
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Created from ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Created until ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            // 'create' => Pages\CreateCustomer::route('/create'),
            'view' => Pages\ViewCustomer::route('/{record}'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
