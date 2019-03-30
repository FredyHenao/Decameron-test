<?php

namespace App\Container\Decameron\Src;

use Illuminate\Database\Eloquent\Model;

class TypeRoom extends Model
{
    protected $table = 'type_rooms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    //relationships many to many  de la tabla type_rooms con la tabla accommodation
    public function accommodations()
    {
        return $this->belongsToMany(Accommodation::class, 'type_room_accommodation', 'type_room_id', 'accommodation_id');
    }

    //relationships many to many  de la tabla type_rooms con la tabla hotels
    public function hotels()
    {
        return $this->belongsToMany(TypeRooms::class, 'hotel_type_room', 'type_room_id', 'hotel_id');
    }
}