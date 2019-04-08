<?php

namespace App\Container\Decameron\Src\Controllers;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Container\Decameron\Src\Hotel;
use App\Container\Decameron\Src\TypeRoom;
use App\Container\Decameron\Src\Accommodation;

class HotelController extends Controller
{
    /**
     * Registration of new hotel.
     * @param Request $request
     * @return \Illuminate\Http\Response
     *
     * Swagger
     *
     * @OA\Post(
     *      path="/api/hotel/store",
     *      operationId="hotelStore",
     *      tags={"Hotel"},
     *      summary="Create of hotel",
     *      description="Create of hotels",
     *      @OA\Parameter(
     *          name="name",
     *          description="Name Hotel",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="city",
     *          description="City Hotel",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="number_rooms",
     *          description="Number Rooms of the hotel",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="address",
     *          description="Address Hotel",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="nit",
     *          description="Nit Hotel",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(response=200, description="Ok"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    //Función que se encarga de crear el hotel
    public function store(Request $request)
    {
        $validation = Hotel::where('name', $request->name)->orWhere('nit', $request->nit)->get();
        if(sizeof($validation)){
            return response()->json(['message'=>'Este Hotel ya se encuentra registrado.'], 409);
        }

        $hotel = new Hotel;
        $hotel->name = $request->name;
        $hotel->city = $request->city;
        $hotel->number_rooms = $request->number_rooms;
        $hotel->address = $request->address;
        $hotel->nit = $request->nit;
        $hotel->save();

        return response()->json([
            'hotel' => $hotel,
            'message' => 'Hotel Creado Correctamente!'], 201);
    }

    /**
     * Update hotel.
     * @param Request $request
     * @return \Illuminate\Http\Response
     *
     * Swagger
     *
     * @OA\Put(
     *      path="/api/hotel/update/{id}",
     *      operationId="hotelUpdate",
     *      tags={"Hotel"},'id as idRelation',
     *      summary="Update hotel",
     *      description="Update hotel",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id Hotel",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="name",
     *          description="Name Hotel",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="city",
     *          description="City Hotel",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="number_rooms",
     *          description="Number Rooms of the hotel",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="address",
     *          description="Address Hotel",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="nit",
     *          description="Nit Hotel",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(response=200, description="Ok"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    //Función que se encarga de actualizar un hotel
    public function update(Request $request, $id)
    {
        $hotel = Hotel::find($id);

        if(!$hotel){
            return response()->json(['menssage'=>'Este Hotel no se encuentra registrado.'], 404);
        }else{
            if(($hotel->name == $request->name) && ($hotel->nit != $request->nit))
            {
                $validation = Hotel::where('nit', $request->nit)->get();
                if(sizeof($validation)){
                    return response()->json(['message'=>'Este Hotel ya se encuentra registrado.'], 409);
                }else{
                    $hotel->name = $request->name;
                    $hotel->city = $request->city;
                }
            }

            if(($hotel->name != $request->name) && ($hotel->nit == $request->nit))
            {
                $validation = Hotel::where('name', $request->name)->get();
                //$validation = Hotel::where('name', $request->name)->orWhere('nit', $request->nit)->get();
                if(sizeof($validation)){
                    return response()->json(['message'=>'Este Hotel ya se encuentra registrado.'], 409);
                }else{
                    $hotel->name = $request->name;
                    $hotel->city = $request->city;
                }
            }

            if(($hotel->name != $request->name) && ($hotel->nit != $request->nit))
            {
                $validation = Hotel::where('name', $request->name)->orWhere('nit', $request->nit)->get();
                if(sizeof($validation)){
                    return response()->json(['message'=>'Este Hotel ya se encuentra registrado.'], 409);
                }else{
                    $hotel->name = $request->name;
                    $hotel->city = $request->city;
                }
            }

            $hotel->number_rooms = $request->number_rooms;
            $hotel->address = $request->address;
            $hotel->nit = $request->nit;
            $hotel->save();

            return response()->json([
                'message' => 'Hotel Modificado Correctamente!'], 201);
        }
    }

    /**
     * Read of  hotel.
     * @param Request $request
     * @return \Illuminate\Http\Response
     *
     * Swagger
     *
     * @OA\Get(
     *      path="/api/hotel/show/{id}",
     *      operationId="hotelGet",
     *      tags={"Hotel"},
     *      summary="Read of hotel",
     *      description="Read of hotels",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id Hotel",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(response=200, description="Ok"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    //Función que se encarga de traer un hotel en especifico
    public function getHotel(Request $request)
    {
        //return response()->json(['data' => $hotel, 'suma' => $result, 200);
        $hotel = Hotel::where('id', $request->id)
                        ->with(['typeRooms' => function($query){
                            $query->select('id_relation','accommodation_id', 'type_room_id', 'quantity')->get();
                        }])
                        ->select('id', 'name', 'city', 'number_rooms', 'address', 'nit', 'edited')
                        ->get();

        if(!sizeof($hotel))
        {
            return response()->json(['menssage'=>'Este Hotel no se encuentra registrado.'], 404);
        }
        foreach($hotel[0]->typeRooms as $item)
        {
            $typeRoom = TypeRoom::where('id',$item->type_room_id)->select('name')->get();
            $accommodation = Accommodation::where('id',$item->accommodation_id)->select('name')->get();
            $item->accommodation_name = $accommodation[0]->name;
            $item->type_room_name = $typeRoom[0]->name;
        }
        return response()->json($hotel, 200);

    }

    /**
     * Read all the hotels.
     * @param Request $request
     * @return \Illuminate\Http\Response
     *
     * Swagger
     *
     * @OA\Get(
     *      path="/api/hotel/index",
     *      operationId="hotelAll",
     *      tags={"Hotel"},
     *      summary="Read all the hotels",
     *      description="Read all the hotels",
     *      @OA\Response(response=200, description="Ok"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    //Función que se encarga de traer los hoteles
    public function allHotels(Request $request)
    {
        $hotel = Hotel::select('id', 'name', 'city', 'number_rooms', 'address', 'nit', 'edited')->get();

        if(!sizeof($hotel))
        {
            return response()->json(['message'=>'No hay Hoteles registrados.'], 404);
        }

        return response()->json($hotel, 200);

    }

    /**
     * Delete hotel.
     * @param Request $request
     * @return \Illuminate\Http\Response
     *
     * Swagger
     *
     * @OA\Delete(
     *      path="/api/hotel/delete/{id}",
     *      operationId="hoteldelete",
     *      tags={"Hotel"},
     *      summary="Delete a hotel",
     *      description="Delete a hotel",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id Hotel",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(response=200, description="Ok"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    //Función que se encarga de traer los hoteles
    public function deleteHotel(Request $request, $id)
    {
        if(Hotel::destroy($id))
            return response()->json(['message' => 'Hotel eliminado correctamente'], 200);

        return response()->json(['message' => 'Error al eliminar el Hotel'], 409);

    }

    /**
     * Create type room hotel.
     * @param Request $request
     * @return \Illuminate\Http\Response
     *
     * Swagger
     *
     * @OA\Post(
     *      path="/api/hotel/room/store",
     *      operationId="storeRoomHotel",
     *      tags={"Hotel"},
     *      summary="Create type room hotel",
     *      description="Create type room hotel",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id Hotel",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="type_room_id",
     *          description="Id Type Room",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="accommodation_id",
     *          description="Id Type Accommodation",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="quantity",
     *          description="Number Rooms of the type room",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(response=200, description="Ok"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    //Función que se encarga de agregar los tipos de habitación al hotel
    public function storeRoomHotel(Request $request)
    {
        $hotel = Hotel::find($request->id);
        if(!$hotel || !(TypeRoom::find($request->type_room_id)) || !(Accommodation::find($request->accommodation_id)))
        {
            return response()->json(['menssage'=>'Los datos no coinciden con nuestros registros.'], 404);
        }else {
            $result = $hotel->typeRooms()->where([['type_room_id', $request->type_room_id],['accommodation_id', $request->accommodation_id]])->get();
            if(sizeof($result))
            {
                return response()->json(['menssage'=>'Este tipo de habitación ya se encuentra registrada.'], 409);
            }else{
                $result = $hotel->num_rooms;
                if(($result[0]->accommodations->sum('quantity') + $request->quantity) > $result[0]->number_rooms){
                    return response()->json(['menssage'=>'Excedió el numero permitido de habitaciones del hotel.'], 409);
                }else{
                    if($request->quantity <= 0){
                        return response()->json(['menssage'=>'El Número de habitaciones debe ser mayor a 0.'], 409);
                    }else {
                        $hotel->typeRooms()->attach($request->type_room_id, ['accommodation_id' => $request->accommodation_id,'quantity' => $request->quantity]);
        
                    return response()->json([
                        'message' => 'Tipo de habitación agregada correctamente!'], 201);
                    }
                }
            }
        }
    }

}