<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\order;
class EmployeeAdminTable extends BaseWidget
{
    protected static ?int $sort =3;
    // protected int | string| array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(order::query())
            ->defaultSort("created_at","desc")
            ->columns([
                // Tables\Columns\TextColumn::make("name"),
                // Tables\Columns\TextColumn::make("email"),
            ]);
    }

    // protected function getCards( ):array{
    //     return[
    //         Card::make('Unique views', '192.1k')
    //             ->description( '32k increase' )
    //             ->Chart([7, 2,10,,3, 15,4, 17])
    //             ->descriptionIcon("- s -trending-up " ),
    //         Card::make('Bounce rate', '21%')
    //             ->description( '7 increase' )
    //             ->descriptionIcon( 'heroicon-s-trending-down' ) ,
    //         Card::make( 'Average time on page','3:12')
    //             ->description( '3X increase' )
    //             ->descriptionlcon( 'heroicon-s-trending-up' ) ,
    //     ];
    // }
}
