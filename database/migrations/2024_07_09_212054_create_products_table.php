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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("name",25);
            $table->unsignedSmallInteger("price");
            $table->text("description");
            $table->enum("category",["Soft Drinks", "Bread", "Confectionaries","Energy Drinks", "Wines", "Alcoholic"]);
            $table->string("shape", 50)->nullable();
            $table->string("size",20)->nullable();
            $table->unsignedSmallInteger("stock");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
