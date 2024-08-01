<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $keyType ="string";
    protected $primaryKey ='id';
    public $incrementing = false;

    protected $fillable =[
        "id",
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

    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
