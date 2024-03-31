<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class employee extends Model
{
    use HasFactory;
    protected $fillable = [
        "firstName",
        "lastName",
        "middleName",
        "address",
        "zipCode",
        "dataOfBirth",
        "dateHired",
    ] ;
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
