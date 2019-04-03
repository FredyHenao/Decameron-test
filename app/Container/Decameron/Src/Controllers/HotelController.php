<?php

namespace App\Container\Decameron\Src\Controllers;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Container\Decameron\Src\Hotel;

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
     *      tags={"Hotel"},
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
        }

        $hotel->name = $request->name;
        $hotel->city = $request->city;
        $hotel->number_rooms = $request->number_rooms;
        $hotel->address = $request->address;
        $hotel->nit = $request->nit;
        $hotel->save();

        return response()->json([
            'message' => 'Hotel Modificado Correctamente!'], 201);
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
        $hotel = Hotel::where('id', $request->id)->with(['typeRooms' => function($query){
            $query->with('accommodations')->get();
        }])->get();

        if(!sizeof($hotel))
        {
            return response()->json(['menssage'=>'Este Hotel no se encuentra registrado.'], 409);
        }

        return response()->json([
            'data' => $hotel], 200);

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
        $hotel = Hotel::with(['typeRooms' => function($query){
            $query->with('accommodations')->get();
        }])->get();

        if(!sizeof($hotel))
        {
            return response()->json(['menssage'=>'No hay Hoteles registrados.'], 409);
        }

        return response()->json([
            'data' => $hotel], 200);

    }

    /**
     * Read all the hotels.
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

    public function storeTypeRoom(Request $request)
    {
        $hotel = Hotel::find($request->id);
        $hotel->typeRooms()->attach($request->type_room_id, ['quantity' => $request->quantity]);
        
        return response()->json([
            'message' => 'Tipo de habitación agregada correctamente!'], 201);
    }

}