<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\Lokasi;
use Illuminate\Database\Eloquent\Factories\Factory;

class BukuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Buku::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'kode_buku' => rand(1000, 2000),
            'judul' => $this->faker->word(),
            'pengarang' => $this->faker->name,
            'penerbit' => $this->faker->name,
            'tahun' => rand(2000, 2021),
            'jumlah' => 10,
            'isbn' => $this->faker->word(),
            'lokasi_id' => function(){
                return Lokasi::all()->random();
            },
            'gambar' => $this->faker->word()
        ];
    }
}
