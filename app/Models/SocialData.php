<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialData extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'data', // Assuming 'data' field stores the JSON object
    ];

    protected $casts = [
        'data' => 'array', // Ensure 'data' is casted as an array
    ];
}
