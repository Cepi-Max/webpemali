<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OfficialFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->name();
        
        return [
            'author_id'      => User::inRandomOrder()->first()->id ?? User::factory(),
            'slug'           => Str::slug($name) . '-' . Str::random(5),
            'name'           => $name,
            'address'        => $this->faker->address(),
            'gender'         => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'place_of_birth' => $this->faker->city(),
            'date_of_birth'  => $this->faker->date('Y-m-d', '2000-12-31'),
            'position' => $this->faker->randomElement([
                            'Kepala Desa',
                            'Sekretaris Desa',
                            'Kaur Keuangan',
                            'Kaur Umum dan Perencanaan',
                            'Kasi Pemerintahan',
                            'Kasi Kesejahteraan',
                            'Kasi Pelayanan',
                            'Ketua RT',
                            'Ketua RW',
                        ]),
            'phone_number'   => $this->faker->phoneNumber(),
            'image'          => 'default.png', // atau generate image jika perlu
        ];
    }
}
