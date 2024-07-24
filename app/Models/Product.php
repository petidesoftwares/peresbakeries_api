<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'price',
        'description',
        'shape',
        'size',
        'stock',
    ];

    public function productCart(){
        return $this->hasMany("App\Models\Cart","product_id","id");
    }

    public function productSale(){
        return $this->hasMany("App\Models\Sales","product_id"," id");
    }
}
