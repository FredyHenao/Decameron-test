<?php

use Illuminate\Database\Seeder;
use App\Container\Decameron\Src\TypeRoom;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $typeRoom = TypeRoom::find(1);
        $typeRoom->accommodations()->attach([1,2]);
        $typeRoom->save();

        $typeRoom = TypeRoom::find(2);
        $typeRoom->accommodations()->attach([3,4]);
        $typeRoom->save();


        $typeRoom = TypeRoom::find(3);
        $typeRoom->accommodations()->attach([1,2,3]);
        $typeRoom->save();

    }
}