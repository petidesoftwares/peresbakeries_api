<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'ref_id',
        'staff_id',
        'product_id',
        'quantity',
        'price',
        'amount',
        "payment_method",
    ];

    public function soldProduct(){
        return $this->belongsTo("App\Models\Product","product_id","id");
    }

    public function soldBy(){
        return $this->belongsTo("App\Models\Staff","staff_id","id");
    }
}
