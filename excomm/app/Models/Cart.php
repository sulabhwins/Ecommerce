<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'product_id', 'quantity'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public static function getCartCountForLoggedInUser()
    {
        $userId = Auth::id();

        if ($userId) {
            $cartCount = self::where('user_id', $userId)->count();
            return $cartCount;
        }

        return 0;
    }
}
