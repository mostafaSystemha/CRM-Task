<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
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
    protected static ?string $navigationGroup ="__('translations.customer_settings')";
    protected static ?string $navigationIcon = 'heroicon-o-users';
    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make(__('translations.English_Details'))->schema([
                TextInput::make('name_en')->required()->label(__('translations.English_Name')),
                TextInput::make('email')
                ->label(__('translations.email'))
                ->required()
                ->suffix('@gmail.com'),
                MarkdownEditor::make('address_en')->required()->label(__('translations.English_Address')),
            ])->columnSpan(2),
            Group::make()->schema([
                Section::make(__('translations.action_status'))->schema([
                    Toggle::make('call')
                        ->label(__('translations.call')),
                    Toggle::make('visit')
                        ->label(__('translations.visit')),
                    Toggle::make('follow-up')
                        ->label(__('translations.follow_up')),
                    TextInput::make('link')
                        ->label(__('translations.link'))
                        ->prefix('www.')
                        ->suffix('.com'),
                ])->columnSpan(1),
            ]),
            Section::make(__('translations.Arabic_Details'))->schema([
                TextInput::make('name_ar')->required()->label(__('translations.Arabic_Name')),
                MarkdownEditor::make('address_ar')->required()->label(__('translations.Arabic_Address')),
            ])->columnSpan(2),
            Group::make()->schema([
                Section::make(__('translations.assign_to_employee'))->schema([
                    Select::make('user_id')
                    ->relationship(name: 'User', titleAttribute: 'name')
                    ->label(__('translations.employee'))
                    ->searchable()
                    ->preload()
                ])->columnSpan(1),
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
                ImageColumn::make('image')->circular()
                    ->label(__('translations.customer_image'))
                    ->searchable(),
                TextColumn::make('User.name')
                    ->label(__('translations.assign_employee'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name_en')
                    ->label(__('translations.name_en'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name_ar')
                    ->label(__('translations.name_ar'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('translations.email'))
                    ->searchable(),
                ToggleColumn::make('call')
                    ->label(__('translations.call_action'))
                    ->disabled(),
                ToggleColumn::make('visit')
                    ->label(__('translations.visit_action'))
                    ->disabled(),
                ToggleColumn::make('follow-up')
                    ->label(__('translations.follow_up_action'))
                    ->disabled(),
                TextColumn::make('created_at')
                    ->label(__('translations.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label(__('translations.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                ])
                ->filters([
                    SelectFilter::make('User')
                    ->relationship('User', 'name')
                    ->searchable()
                    ->preload()
                    ->label(__('translations.filter_by_user'))
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view' => Pages\ViewCustomer::route('/{record}'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
