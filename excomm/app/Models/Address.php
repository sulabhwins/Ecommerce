<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'street_address',
        'city',
        'state',
        'postal_code',
        // Add other fillable fields as needed
    ];
}
