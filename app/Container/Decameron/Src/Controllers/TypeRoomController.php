<?php

namespace App\Container\Decameron\Src\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Container\Decameron\Src\TypeRoom;
use Illuminate\Support\Facades\Auth;

class TypeRoomController extends Controller
{
    /**
     * Read all the type rooms.
     * @param Request $request
     * @return \Illuminate\Http\Response
     *
     * Swagger
     *
     * @OA\Get(
     *      path="/api/room/index",
     *      operationId="roomAll",
     *      tags={"Type Room"},
     *      summary="Read all the types romms",
     *      description="Read all the types romms",
     *      @OA\Response(response=200, description="Ok"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    //Función que se encarga de traer los tipos de habitaciones
    public function getAll(Request $request)
    {
        $data = TypeRoom::select('id', 'name')
                          ->get();
        if(!sizeof($data))
            return response()->json(['message'=>'No hay tipos de habitaciones registradas.'], 409);  
             
        return response()->json($data, 200);
    }

    /**
     * Read the type room.
     * @param Request $request
     * @return \Illuminate\Http\Response
     *
     * Swagger
     *
     * @OA\Get(
     *      path="/api/room/accommodations/{id}",
     *      operationId="roomGet",
     *      tags={"Type Room"},
     *      summary="Read the type of room",
     *      description="Read the type of room",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id type room",
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
    //Función que se encarga de traer un tipo de habitación en especifico con sus acomodaciones
    public function getAccommodation(Request $request)
    {
        $data = TypeRoom::where('id', $request->id)
                          ->with(['accommodations' => function($query) {
                              return $query->select('id', 'name')->get();
                          }])
                          ->select('id', 'name')
                          ->get();

        if(!sizeof($data))
            return response()->json(['message'=>'Este tipo de habitación no se encuentra registrada.'], 404);
                  
        return response()->json($data[0], 200);
    }
}