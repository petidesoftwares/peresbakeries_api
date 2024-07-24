<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'price',
        'amount',
    ];

    public function cartProduct(){
        return $this->belongsTo("App\Models\Product","product_id","id");
    }
}
