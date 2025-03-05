<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Smartphone',
                'description' => 'Ultimo modello con fotocamera avanzata.',
                'price' => 699.99,
                'stock' => 10,
                'image' => 'prod_img/product1.jpg', // ✅ Percorso dell'immagine
                'category_id' => 1
            ],
            [
                'name' => 'Laptop',
                'description' => 'Notebook potente per il lavoro e il gaming.',
                'price' => 1299.99,
                'stock' => 5,
                'image' => 'prod_img/product2.jpg',
                'category_id' => 1
            ],
            [
                'name' => 'Cuffie Bluetooth',
                'description' => 'Audio di alta qualità e cancellazione del rumore.',
                'price' => 199.99,
                'stock' => 20,
                'image' => 'prod_img/product3.jpg',
                'category_id' => 1
            ],
            [
                'name' => 'Smartphone',
                'description' => 'Ultimo modello con fotocamera avanzata.',
                'price' => 699.99,
                'stock' => 10,
                'image' => 'prod_img/product1.jpg', // ✅ Percorso dell'immagine
                'category_id' => 1
            ],
            [
                'name' => 'Laptop',
                'description' => 'Notebook potente per il lavoro e il gaming.',
                'price' => 1299.99,
                'stock' => 5,
                'image' => 'prod_img/product2.jpg',
                'category_id' => 1
            ],
            [
                'name' => 'Cuffie Bluetooth',
                'description' => 'Audio di alta qualità e cancellazione del rumore.',
                'price' => 199.99,
                'stock' => 20,
                'image' => 'prod_img/product3.jpg',
                'category_id' => 1
            ],
            [
                'name' => 'Smartphone',
                'description' => 'Ultimo modello con fotocamera avanzata.',
                'price' => 699.99,
                'stock' => 10,
                'image' => 'prod_img/product1.jpg', // ✅ Percorso dell'immagine
                'category_id' => 1
            ],
            [
                'name' => 'Laptop',
                'description' => 'Notebook potente per il lavoro e il gaming.',
                'price' => 1299.99,
                'stock' => 5,
                'image' => 'prod_img/product2.jpg',
                'category_id' => 1
            ],
            [
                'name' => 'Cuffie Bluetooth',
                'description' => 'Audio di alta qualità e cancellazione del rumore.',
                'price' => 199.99,
                'stock' => 20,
                'image' => 'prod_img/product3.jpg',
                'category_id' => 1
            ],
            [
                'name' => 'Smartphone',
                'description' => 'Ultimo modello con fotocamera avanzata.',
                'price' => 699.99,
                'stock' => 10,
                'image' => 'prod_img/product1.jpg', // ✅ Percorso dell'immagine
                'category_id' => 1
            ],
            [
                'name' => 'Laptop',
                'description' => 'Notebook potente per il lavoro e il gaming.',
                'price' => 1299.99,
                'stock' => 5,
                'image' => 'prod_img/product2.jpg',
                'category_id' => 1
            ],
            [
                'name' => 'Cuffie Bluetooth',
                'description' => 'Audio di alta qualità e cancellazione del rumore.',
                'price' => 199.99,
                'stock' => 20,
                'image' => 'prod_img/product3.jpg',
                'category_id' => 1
            ],
            [
                'name' => 'Smartphone',
                'description' => 'Ultimo modello con fotocamera avanzata.',
                'price' => 699.99,
                'stock' => 10,
                'image' => 'prod_img/product1.jpg', // ✅ Percorso dell'immagine
                'category_id' => 1
            ],
            [
                'name' => 'Laptop',
                'description' => 'Notebook potente per il lavoro e il gaming.',
                'price' => 1299.99,
                'stock' => 5,
                'image' => 'prod_img/product2.jpg',
                'category_id' => 1
            ],
            [
                'name' => 'Cuffie Bluetooth',
                'description' => 'Audio di alta qualità e cancellazione del rumore.',
                'price' => 199.99,
                'stock' => 20,
                'image' => 'prod_img/product3.jpg',
                'category_id' => 1
            ],
            [
                'name' => 'Smartphone',
                'description' => 'Ultimo modello con fotocamera avanzata.',
                'price' => 699.99,
                'stock' => 10,
                'image' => 'prod_img/product1.jpg', // ✅ Percorso dell'immagine
                'category_id' => 1
            ],
            [
                'name' => 'Laptop',
                'description' => 'Notebook potente per il lavoro e il gaming.',
                'price' => 1299.99,
                'stock' => 5,
                'image' => 'prod_img/product2.jpg',
                'category_id' => 1
            ],
            [
                'name' => 'Cuffie Bluetooth',
                'description' => 'Audio di alta qualità e cancellazione del rumore.',
                'price' => 199.99,
                'stock' => 20,
                'image' => 'prod_img/product3.jpg',
                'category_id' => 1
            ],
            [
                'name' => 'Smartphone',
                'description' => 'Ultimo modello con fotocamera avanzata.',
                'price' => 699.99,
                'stock' => 10,
                'image' => 'prod_img/product1.jpg', // ✅ Percorso dell'immagine
                'category_id' => 1
            ],
            [
                'name' => 'Laptop',
                'description' => 'Notebook potente per il lavoro e il gaming.',
                'price' => 1299.99,
                'stock' => 5,
                'image' => 'prod_img/product2.jpg',
                'category_id' => 1
            ],
            [
                'name' => 'Cuffie Bluetooth',
                'description' => 'Audio di alta qualità e cancellazione del rumore.',
                'price' => 199.99,
                'stock' => 20,
                'image' => 'prod_img/product3.jpg',
                'category_id' => 1
            ],
            [
                'name' => 'Smartphone',
                'description' => 'Ultimo modello con fotocamera avanzata.',
                'price' => 699.99,
                'stock' => 10,
                'image' => 'prod_img/product1.jpg', // ✅ Percorso dell'immagine
                'category_id' => 1
            ],
            [
                'name' => 'Laptop',
                'description' => 'Notebook potente per il lavoro e il gaming.',
                'price' => 1299.99,
                'stock' => 5,
                'image' => 'prod_img/product2.jpg',
                'category_id' => 1
            ],
            [
                'name' => 'Cuffie Bluetooth',
                'description' => 'Audio di alta qualità e cancellazione del rumore.',
                'price' => 199.99,
                'stock' => 20,
                'image' => 'prod_img/product3.jpg',
                'category_id' => 1
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

