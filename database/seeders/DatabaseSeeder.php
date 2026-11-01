<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
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
        $demo = User::factory()->create([
            'name' => 'Compte démo',
            'email' => 'demo@larastock.fr',
            'password' => 'password',
        ]);

        $categories = collect(['Alimentation', 'Boissons', 'Hygiène', 'Papeterie', 'Entretien', 'Électronique'])
            ->map(fn (string $name): Category => Category::create(['name' => $name]))
            ->keyBy('name');

        // [nom, référence, quantité, prix, seuil d'alerte]
        // quantité = 0 → rupture ; quantité <= seuil → stock faible
        $catalogue = [
            'Alimentation' => [
                ['Riz 5 kg', 'RIZ-5KG', 20, '4.50', 5],
                ['Pâtes penne 500 g', 'PAT-500', 50, '1.20', 10],
                ['Huile d’olive 1 L', 'HUI-1L', 8, '6.90', 10],
                ['Sucre 1 kg', 'SUC-1KG', 15, '1.80', 5],
                ['Farine 1 kg', 'FAR-1KG', 0, '1.50', 4],
                ['Café moulu 250 g', 'CAF-250', 12, '3.75', 4],
            ],
            'Boissons' => [
                ['Eau plate 6 x 1,5 L', 'EAU-6X15', 30, '2.90', 6],
                ['Jus d’orange 1 L', 'JUS-ORA', 10, '2.20', 4],
                ['Thé vert', 'THE-VERT', 6, '3.10', 8],
                ['Cola 1,5 L', 'COC-15L', 18, '2.40', 6],
                ['Lait demi-écrémé 6 x 1 L', 'LAI-6X1', 24, '5.40', 8],
                ['Jus de mangue 1 L', 'JUS-MANG', 0, '2.60', 3],
            ],
            'Hygiène' => [
                ['Savon 125 g', 'SAV-125', 40, '1.20', 8],
                ['Shampoing 300 mL', 'SHA-300', 15, '3.50', 5],
                ['Dentifrice 75 mL', 'DEN-75', 25, '2.30', 6],
                ['Papier toilette 12 rouleaux', 'PAP-12', 0, '4.90', 5],
                ['Gel douche 250 mL', 'GEL-250', 2, '2.80', 3],
                ['Brosse à dents', 'BRO-DEN', 18, '2.10', 5],
            ],
            'Papeterie' => [
                ['Cahier 96 pages', 'CAH-96', 22, '1.90', 6],
                ['Stylos bille x10', 'STY-10', 30, '2.50', 8],
                ['Ramette A4', 'RAM-A4', 7, '4.20', 8],
                ['Classeur', 'CLA-001', 10, '3.40', 4],
                ['Ciseaux', 'CIS-001', 0, '2.10', 2],
                ['Marqueurs fluo x4', 'MAR-4', 18, '3.00', 5],
            ],
            'Entretien' => [
                ['Lessive 3 L', 'LES-3L', 12, '6.50', 4],
                ['Liquide vaisselle 500 mL', 'VAI-500', 16, '1.90', 5],
                ['Éponges x5', 'EPO-5', 25, '1.50', 6],
                ['Sacs poubelle 30 L x20', 'SAC-30L', 3, '2.20', 5],
                ['Javel 1 L', 'JAV-1L', 8, '1.80', 3],
                ['Balai', 'BAL-001', 1, '7.90', 2],
            ],
            'Électronique' => [
                ['Piles AA x4', 'PIL-AA4', 20, '4.50', 5],
                ['Ampoule LED', 'AMP-LED', 14, '3.90', 4],
                ['Câble USB-C 1 m', 'USB-C1M', 0, '5.90', 3],
                ['Chargeur 65 W', 'CHA-65W', 2, '24.90', 3],
                ['Multiprise 5 prises', 'MUL-5P', 9, '11.50', 3],
                ['Enceinte Bluetooth', 'ENC-BT', 1, '39.90', 2],
            ],
        ];

        foreach ($catalogue as $categoryName => $items) {
            $category = $categories->get($categoryName);

            foreach ($items as [$name, $sku, $quantity, $price, $threshold]) {
                Product::create([
                    'category_id' => $category->id,
                    'created_by' => $demo->id,
                    'name' => $name,
                    'sku' => $sku,
                    'quantity' => $quantity,
                    'price' => $price,
                    'low_stock_threshold' => $threshold,
                ]);
            }
        }
    }
}
