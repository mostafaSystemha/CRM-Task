<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class customer extends Model
{
    use HasFactory;
    protected $fillable = [
        "name_en",
        "name_ar",
        "address_en",
        "address_ar",
        "email",
        "image",
        "call",
        "visit",
        "follow-up",
        "link",
        "user_id",
    ] ;
    // public function Employee(): BelongsTo
    // {
    //     return $this->belongsTo(employee::class);
    // }
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
