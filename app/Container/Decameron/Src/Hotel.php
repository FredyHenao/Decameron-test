<?php

namespace App\Container\Decameron\Src;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $table = 'hotels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'city', 'number_rooms', 'address', 'nit'
    ];

    //relationships many to many  de la tabla type_rooms con la tabla type_rooms
    public function typeRooms()
    {
        return $this->belongsToMany(TypeRooms::class, 'hotel_type_room', 'hotel_id', 'type_room_id');
    }
}
