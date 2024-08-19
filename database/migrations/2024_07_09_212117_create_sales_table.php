<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->uuid("ref_id");
            $table->foreignUuid("product_id")->constrained();
            $table->unsignedSmallInteger("quantity");
            $table->unsignedSmallInteger("price");
            $table->unsignedBigInteger("amount");
            $table->string("payment_method");
            $table->foerignUuid("staff_id")->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
