<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Cat;
use Illuminate\Database\Seeder;

final class CatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаем взрослых котов и кошек
        $mothers = Cat::factory()->count(5)->create([
            'gender' => 'female',
            'age' => rand(2, 10)
        ]);

        $fathers = Cat::factory()->count(5)->create([
            'gender' => 'male',
            'age' => rand(2, 10)
        ]);

        // Создаем котят с родителями
        Cat::factory()->count(20)->create([
            'age' => rand(0, 1),
            'mother_id' => fn() => $mothers->random()->id
        ])->each(function($kitten) use ($fathers) {
            $kitten->fathers()->attach(
                $fathers->random(rand(1, 3))->pluck('id')
            );
        });
    }
}
