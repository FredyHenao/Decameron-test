<?php

namespace App\Container\Decameron\Src\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Container\Decameron\Src\TypeRoom;
use Illuminate\Support\Facades\Auth;

class TypeRoomController extends Controller
{
    public function getAll(Request $request)
    {
        $data = TypeRoom::select('id', 'name')
                          ->get();
        return $data;
    }

    public function getAccommodation(Request $request)
    {
        $data = TypeRoom::where('id', $request->id)
                          ->with(['accommodations' => function($query) {
                              return $query->select('id', 'name')->get();
                          }])
                          ->select('id', 'name')
                          ->get();

        return $data;
    }
}