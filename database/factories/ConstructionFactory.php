<?php

namespace Database\Factories;

use App\Models\Construction;
use App\Models\User;
use App\Models\ConstructionFundSourceCategories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ConstructionFactory extends Factory
{
    protected $model = Construction::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(3);

        return [
            'slug' => Str::slug($title) . '-' . Str::random(5),
            'title' => $title,
            'author_id' => User::factory(),
            'fund_source_id' => ConstructionFundSourceCategories::factory(),

            'government_cost' => $this->faker->optional()->numberBetween(1000000, 100000000),
            'district_cost' => $this->faker->optional()->numberBetween(1000000, 100000000),
            'province_cost' => $this->faker->optional()->numberBetween(1000000, 100000000),
            'self_cost' => $this->faker->optional()->numberBetween(1000000, 100000000),
            'total_budget' => $this->faker->numberBetween(5000000, 300000000),

            'construction_site' => $this->faker->address(),
            'construction_implementer' => $this->faker->company(),
            'construction_volume' => $this->faker->randomDigitNotZero() . ' unit',
            'construction_time_period' => $this->faker->randomElement(['1 bulan', '3 bulan', '6 bulan']),
            'period_category' => $this->faker->randomElement(['Triwulan I', 'Triwulan II', 'Semester I', 'Tahunan']),
            'construction_traits' => $this->faker->randomElement(['Baru', 'Rehabilitasi', 'Peningkatan']),
            'construction_benefits' => $this->faker->sentence(6),
            'information' => $this->faker->sentence(),
            'fiscal_year' => $this->faker->year(),
            'latitude' => $this->faker->latitude(-11, 6),
            'longitude' => $this->faker->longitude(95, 141),
            'image' => 'default.png',
        ];
    }
}
