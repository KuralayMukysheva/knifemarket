<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Knife;

class KnifeSeeder extends Seeder
{
    public function run()
    {
        $knives = [
            [
                'title' => 'Karambit',
                'description' => 'Изогнутый нож, вдохновленный юго-восточной Азией.',
                'price' => 250.00,
                'image' => 'karambit-2.jpg',
            ],
            [
                'title' => 'Butterfly Knife',
                'description' => 'Складной нож с уникальной анимацией.',
                'price' => 300.00,
                'image' => 'butterfly.jpg',
            ],
            [
                'title' => 'Falchion Knife',
                'description' => 'Нож с изогнутым лезвием и уникальной анимацией.',
                'price' => 120.00,
                'image' => 'falchion.jpg',
            ],
            [
                'title' => 'Huntsman Knife',
                'description' => 'Тактический нож для выживания.',
                'price' => 180.00,
                'image' => 'huntsman-1.jpg',
            ],
            [
                'title' => 'Gut Knife',
                'description' => 'Нож с крюком для потрошения.',
                'price' => 90.00,
                'image' => 'gut-1.jpg',
            ],
            [
                'title' => 'Flip Knife',
                'description' => 'Складной нож с длинным лезвием.',
                'price' => 150.00,
                'image' => 'flip-1.jpg',
            ],
        ];

        foreach ($knives as $knife) {
            Knife::create($knife);
        }
    }
}
