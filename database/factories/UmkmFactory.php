<?php

namespace Database\Factories;

use App\Models\Umkm;
use App\Models\UmkmSector;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Umkm>
 */
class UmkmFactory extends Factory
{
    protected $model = Umkm::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'slug' => Str::slug(fake()->words(3, true)),
            'author_id' => User::factory(),
            'sector_id' => UmkmSector::factory(),
            'umkm_name' => fake()->words(3, true),
            'owner_name' => fake()->name(),
            'description' => fake()->sentence(),
            'gender' => fake()->randomElement(['male', 'female']),
            'address' => fake()->address(),
            'email' => fake()->safeEmail(),
            'product_price' => fake()->randomFloat(2, 100, 1000),
            'number_phone' => fake()->phoneNumber(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'image' =>'default.jpg',
        ];
    }
}
