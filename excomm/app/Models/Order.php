<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'address_id',
        'user_id',
       
    ];
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}
public function product()
{
    return $this->belongsTo(Product::class, 'product_id');
}
    
}
