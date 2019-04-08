<?php

namespace App\Container\Decameron\Src\Traits;

use Carbon\Carbon;
use Illuminate\Support\Collection as Collection;

trait HotelTRait {

    public function getNumRoomsAttribute()
    {
        return $this->where('id', $this->id)->with(['accommodations' => function ($query) {
            return $query->select('quantity')->get();
        }])->select('id', 'name', 'number_rooms')->get();
    }
}