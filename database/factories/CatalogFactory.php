<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catalog>
 */
class CatalogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $catalogs = ['Buku Dewasa', 'Buku Anak', 'Buku Belajar', 'Buku Kesehatan'];
        return [
            'name' => $this->faker->unique()->randomElement($catalogs),
        ];
    }
}
