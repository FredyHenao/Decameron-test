<?php

namespace App\Container\Decameron\Src;

use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    protected $table = 'accommodations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    //relationships many to many de la tabla accommodation con la tabla type_rooms
    public function typeRooms()
    {
        return $this->belongsToMany(TypeRoom::class, 'type_room_accommodation', 'accommodation_id', 'type_room_id'); 
    }

    //relationships many to many  de la tabla accommodations con la tabla hotels
    public function hotels()
    {
        return $this->belongsToMany(Accommodation::class, 'hotel_type_room_accommodation', 'accommodation_id', 'hotel_id')->withPivot('quantity');
    }
}