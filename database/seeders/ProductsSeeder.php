<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'description' => "Filetes de aguja",
            'stock' => 50,
            'sale' => 1,
            'priceKG' => 8,
            'urlImagen' => "assets/filetesdeaguja.png",
            'category_id' => 1
        ]);

        Product::create([
            'description' => "Carne Picada mixta de cerdo y ternera",
            'stock' => 25,
            'sale' => 0,
            'priceKG' => 12,
            'urlImagen' => "assets/carnepicada.png",
            'category_id' => 1
        ]);

        Product::create([
            'description' => "Lomo de vaca extra",
            'stock' => 25,
            'sale' => 1,
            'priceKG' => 30,
            'urlImagen' => "assets/lomodevaca.png",
            'category_id' => 2
        ]);

        Product::create([
            'description' => "Solomillo de vaca extra al corte",
            'stock' => 25,
            'sale' => 0,
            'priceKG' => 42.99,
            'urlImagen' => "assets/solomillodevaca.png",
            'category_id' => 2
        ]);

        Product::create([
            'description' => "Costillas Frescas",
            'stock' => 100,
            'sale' => 0,
            'priceKG' => 13.99,
            'urlImagen' => "assets/costillasfrescas.png",
            'category_id' => 3
        ]);

        Product::create([
            'description' => "Costillas Adobadas",
            'stock' => 100,
            'sale' => 1,
            'priceKG' => 13.99,
            'urlImagen' => "assets/costillasadobadas.png",
            'category_id' => 3
        ]);
    }
}   
