<?php

namespace App\Filament\Widgets;

use App\Models\order;
use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UsersAdminTable extends BaseWidget
{
    protected static ?string $header = "Users ";
    protected static ?int $sort =5;
    // protected int | string| array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(User::query())
            ->defaultSort("created_at","desc")
            ->columns([
                Tables\Columns\TextColumn::make("name"),
                Tables\Columns\TextColumn::make("email"),
            ]);
    }
}
