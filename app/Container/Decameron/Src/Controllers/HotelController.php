<?php

namespace App\Container\Decameron\Src\Controllers;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Container\Decameron\Src\Hotel;

class HotelController extends Controller
{
    public function store(Request $request)
    {
        $validation = Hotel::where('name', $request->name)->orWhere('nit', $request->nit)->get();
        if(sizeof($validation)){
            return response()->json(['menssage'=>'Este Hotel ya se encuentra registrado.'], 409);
        }

        $hotel = new Hotel;
        $hotel->name = $request->name;
        $hotel->city = $request->city;
        $hotel->number_rooms = $request->number_rooms;
        $hotel->address = $request->address;
        $hotel->nit = $request->nit;
        $hotel->save();

        return response()->json([
            'message' => 'Hotel Creado Correctamente!'], 201);
    }

    public function storeTypeRoom(Request $request)
    {
        $hotel = Hotel::find($request->id);
        $hotel->typeRooms()->attach($request->type_room_id, ['quantity' => $request->quantity]);
        return $hotel;
    }

}