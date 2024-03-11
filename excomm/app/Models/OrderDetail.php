<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'order_id',
        'product_quantity',
        'product_name',
        'price',
        'quantity'
        // other fields...
    ];
    public function order()
  {
      return $this->belongsTo(Order::class);
  }
  public function product()
  {
      return $this->belongsTo(Product::class);
  }
  public function address()
  {
      return $this->belongsTo(Address::class);
  }
  public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
