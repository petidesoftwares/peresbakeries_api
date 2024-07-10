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
        Schema::create('staff', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("firstname",50);
            $table->string("surname", 50);
            $table->enum("gender",['Male', 'Female'])->default("Male");
            $table->string("mobile_number", 15);
            $table->string("position", 30);
            $table->text("address");
            $table->string("dob");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
