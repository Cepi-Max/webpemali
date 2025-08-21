<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ConstructionFundSourceCategoriesFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->randomElement([
            'APBD Kabupaten',
            'APBD Provinsi',
            'Dana Desa',
            'CSR',
            'Swadaya Masyarakat',
            'Bantuan Pemerintah',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::random(4),
        ];
    }
}
