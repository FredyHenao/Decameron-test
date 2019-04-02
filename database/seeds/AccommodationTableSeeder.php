<?php

use Illuminate\Database\Seeder;
use App\Container\Decameron\Src\Accommodation;

class AccommodationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accommodation = new Accommodation;
        $accommodation->name = 'Sencilla';
        $accommodation->save();

        $accommodation = new Accommodation;
        $accommodation->name = 'Doble';
        $accommodation->save();

        $accommodation = new Accommodation;
        $accommodation->name = 'Triple';
        $accommodation->save();

        $accommodation = new Accommodation;
        $accommodation->name = 'Cuádruple';
        $accommodation->save();

    }
}