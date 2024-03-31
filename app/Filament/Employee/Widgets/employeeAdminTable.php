<?php

namespace App\Filament\Employee\Widgets;

use Filament\Widgets\ChartWidget;

class employeeAdminTable extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [

        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
