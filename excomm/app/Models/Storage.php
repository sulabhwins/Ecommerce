<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory;

    protected $fillable = [
        'products_id',
        'quintity',
    ];

    // Define relationships if needed
    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }
}
