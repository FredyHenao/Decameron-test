<?php

namespace App\Container\Decameron\Src;

use Illuminate\Database\Eloquent\Model;
use App\Container\Decameron\Src\Traits\HotelTrait;

class Hotel extends Model
{
    use HotelTrait;

    //protected $appens = ['num_rooms'];
    protected $table = 'hotels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'city', 'number_rooms', 'address', 'nit'
    ];

    //relationships many to many  de la tabla hotels con la tabla type_rooms
    public function typeRooms()
    {
        return $this->belongsToMany(TypeRoom::class, 'hotel_type_room_accommodation', 'hotel_id', 'type_room_id')->withPivot('quantity');
    }

    //relationships many to many  de la tabla hotels con la tabla accommodation
    public function accommodations()
    {
        return $this->belongsToMany(Accommodation::class, 'hotel_type_room_accommodation', 'hotel_id', 'accommodation_id')->withPivot('quantity');
    }
}
