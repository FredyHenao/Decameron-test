<?php

use Illuminate\Database\Seeder;
use App\Container\Decameron\Src\TypeRoom;

class TypeRoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $typeRoom = new TypeRoom;
        $typeRoom->name = 'Estándar';
        $typeRoom->save();

        $typeRoom = new TypeRoom;
        $typeRoom->name = 'Junior';
        $typeRoom->save();

        $typeRoom = new TypeRoom;
        $typeRoom->name = 'Suite';
        $typeRoom->save();

    }
}