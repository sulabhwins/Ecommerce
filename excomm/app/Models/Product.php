<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'vender_id',
        'name',
        'color',
        'titel',
        'description',
        'saling_price',
        'quintity',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'isfeatured',
        'status',
    ];

    // Define relationships if you have any
    public function category()
    {
        return $this->belongsTo(Categorie::class, 'category_id');
    }

    public function vender()
    {
        return $this->belongsTo(Admin::class, 'vender_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'product_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }


}
