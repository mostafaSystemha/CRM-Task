<?php

namespace App\Filament\Employee\Resources\CustomerResource\Pages;

use App\Filament\Employee\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;
}
