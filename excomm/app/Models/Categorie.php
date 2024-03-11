<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'category_name',
        'subcategory_id',
        'vender_id',
        'category_discount',
        'category_image',
        'name',
        'color',
        'titel',
        'description',
        'saling_price',
        'url',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'isfeatured',
        'status',
        // Add other fields as needed
    ];

    public function parentCategory()
    {
        return $this->hasOne(Categorie::class, 'id', 'parent_id')
            ->select('id', 'category_name', 'url')
            ->where('status', 1);
    }

    public function subcategories()
    {
        return $this->hasMany(Categorie::class, 'parent_id');
    }
}
