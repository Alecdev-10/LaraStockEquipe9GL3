<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = [
            'Ordinateurs et périphériques',
            'Composants informatiques',
            'Réseau et stockage',
            'Audio, vidéo et photo',
            'Création de contenu et accessoires',
        ];

        $categoryIds = [];

        foreach ($categories as $categoryName) {
            $categoryIds[$categoryName] = Category::firstOrCreate([
                'name' => $categoryName,
            ])->id;
        }

        $products = [
            ['Ordinateurs et périphériques', 'PC-PORT-001', 'Ordinateur portable Lenovo ThinkPad E14', 8, 565000, 3],
            ['Ordinateurs et périphériques', 'PC-PORT-002', 'Ordinateur portable HP ProBook 450', 4, 625000, 5],
            ['Ordinateurs et périphériques', 'PC-PORT-003', 'Ordinateur portable Dell Inspiron 15', 0, 540000, 3],
            ['Ordinateurs et périphériques', 'PC-PORT-004', 'MacBook Air 13 pouces M3', 2, 950000, 2],
            ['Ordinateurs et périphériques', 'PC-PORT-005', 'Écran LG UltraWide 29 pouces', 6, 245000, 3],
            ['Ordinateurs et périphériques', 'PC-PORT-006', 'Clavier mécanique Logitech K835', 12, 48000, 5],

            ['Composants informatiques', 'COMP-001', 'Processeur AMD Ryzen 5 5600', 5, 105000, 3],
            ['Composants informatiques', 'COMP-002', 'Processeur Intel Core i5-12400F', 3, 125000, 3],
            ['Composants informatiques', 'COMP-003', 'Carte graphique NVIDIA GeForce RTX 4060', 2, 325000, 2],
            ['Composants informatiques', 'COMP-004', 'Mémoire vive Kingston Fury 16 Go DDR4', 18, 32000, 6],
            ['Composants informatiques', 'COMP-005', 'SSD Samsung 990 EVO 1 To NVMe', 7, 68000, 4],
            ['Composants informatiques', 'COMP-006', 'Alimentation Corsair CX650 650 W', 1, 72000, 3],

            ['Réseau et stockage', 'NET-001', 'Routeur Wi-Fi TP-Link Archer AX23', 9, 52000, 4],
            ['Réseau et stockage', 'NET-002', 'Switch réseau TP-Link 8 ports Gigabit', 4, 28000, 3],
            ['Réseau et stockage', 'NET-003', 'Disque dur externe Seagate 2 To', 6, 55000, 3],
            ['Réseau et stockage', 'NET-004', 'Clé USB SanDisk Ultra 128 Go', 25, 9000, 10],
            ['Réseau et stockage', 'NET-005', 'Point d’accès Wi-Fi Ubiquiti U6+', 0, 105000, 2],
            ['Réseau et stockage', 'NET-006', 'Onduleur APC Back-UPS 900 VA', 3, 78000, 3],

            ['Audio, vidéo et photo', 'AV-001', 'Microphone USB Rode NT-USB Mini', 4, 95000, 3],
            ['Audio, vidéo et photo', 'AV-002', 'Casque audio Sony WH-CH720N', 7, 85000, 4],
            ['Audio, vidéo et photo', 'AV-003', 'Webcam Logitech C920 HD Pro', 2, 65000, 3],
            ['Audio, vidéo et photo', 'AV-004', 'Appareil photo Canon EOS R50', 1, 680000, 2],
            ['Audio, vidéo et photo', 'AV-005', 'Éclairage vidéo LED Neewer 660', 5, 125000, 3],
            ['Audio, vidéo et photo', 'AV-006', 'Trépied photo réglable K&F Concept', 0, 42000, 2],

            ['Création de contenu et accessoires', 'CREA-001', 'Tablette graphique Wacom One Small', 3, 79000, 3],
            ['Création de contenu et accessoires', 'CREA-002', 'Tablette graphique Huion Inspiroy H640P', 6, 38000, 3],
            ['Création de contenu et accessoires', 'CREA-003', 'Hub USB-C UGREEN 6-en-1', 10, 27000, 5],
            ['Création de contenu et accessoires', 'CREA-004', 'Support d’ordinateur portable aluminium', 2, 18000, 3],
            ['Création de contenu et accessoires', 'CREA-005', 'Carte mémoire SanDisk Extreme 128 Go', 8, 22000, 4],
            ['Création de contenu et accessoires', 'CREA-006', 'Fond photo pliable noir et blanc 150 cm', 1, 35000, 2],
        ];

        foreach ($products as [$categoryName, $sku, $name, $quantity, $price, $threshold]) {
            Product::firstOrCreate(
                ['sku' => $sku],
                [
                    'category_id' => $categoryIds[$categoryName],
                    'name' => $name,
                    'quantity' => $quantity,
                    'price' => $price,
                    'low_stock_threshold' => $threshold,
                ],
            );
        }
    }
}
