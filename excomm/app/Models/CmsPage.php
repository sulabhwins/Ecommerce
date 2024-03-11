<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    // You can also use $guarded to specify fields that should not be mass assignable
    // protected $guarded = ['id'];

    // Example of an accessor to modify a field before it is retrieved
    public function getTitleAttribute($value)
    {
        return ucfirst($value); // Capitalize the title before retrieving it
    }

    // Example of a mutator to modify a field before it is saved
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = strtolower($value); // Convert title to lowercase before saving
    }
}
