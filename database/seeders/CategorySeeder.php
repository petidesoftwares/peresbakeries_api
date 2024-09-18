<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories =[
            ["category"=>"Soft Drinks"],
            ["category"=>"Bread"],
            ["category"=>"Confectionaries"],
            ["category"=>"Energy Drinks"],
            ["category"=>"Wines"],
            ["category"=>"Alcholic"]
        ];

        foreach($categories as $category){
            DB::table('categories')->insert($category);
        }
    }
}
