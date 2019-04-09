<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="L5 OpenApi",
 *      description="L5 Swagger OpenApi description",
 *      @OA\Contact(
 *          email="darius@matulionis.lt"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */

class AuthController extends Controller
{
    /**
     * Registration of new users.
     * @param UserCreateRequest $request
     * @return \Illuminate\Http\Response
     *
     * Swagger
     *
     * @OA\Post(
     *      path="/api/auth/signup",
     *      operationId="signup",
     *      tags={"Auth"},
     *      summary="Registration of new users",
     *      description="Registration of new users",
     *      @OA\Parameter(
     *          name="name",
     *          description="Name user",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="email",
     *          description="Email user",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          description="Password user",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password_confirmation",
     *          description="Password confirmation user",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */

    //Función que se encarga de crear un usuario
    public function signup(Request $request)
    {
        $email = User::where('email', $request->email)->get();
        if(sizeof($email))
            return response()->json(['menssage'=>'Ya se encuentra un usuario con este correo'], 409);

        $user = new User([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->save();
        return response()->json([
            'message' => 'Usuario Creado Correctamente!'], 201);
    }


    /**
     * Registration of new users.
     * @param Request $request
     * @return \Illuminate\Http\Response
     *
     * Swagger
     *
     * @OA\Post(
     *      path="/api/auth/login",
     *      operationId="login",
     *      tags={"Auth"},
     *      summary="Login of users",
     *      description="Login of users",
     *      @OA\Parameter(
     *          name="email",
     *          description="Email user",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          description="Password user",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    //Función que se encarga de realizar la validación para la autenticación
    public function login(Request $request)
    {
        $request->validate([
            'email'       => 'required|string|email',
            'password'    => 'required|string',
            'remember_me' => 'boolean',
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) 
            return response()->json(['message' => 'Unauthorized'], 401);
    
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me) 
            $token->expires_at = Carbon::now()->addWeeks(1);
        
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at)
                    ->toDateTimeString(),
        ]);
    }

    //Función que se encarga de realizar el logout correctamente 
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 
            'Sesión cerrada correctamente'], 200);
    }

    /**
     * Registration of new users.
     * @param Request $request
     * @return \Illuminate\Http\Response
     *
     * Swagger
     *
     * @OA\Get(
     *      path="/api/user/all",
     *      operationId="userAll",
     *      tags={"Users"},
     *      summary="Lists of users",
     *      description="Lists of users",
     *      @OA\Response(response=200, description="Ok"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    //Función que se encarga de devolver la data del usuario 
    public function user(Request $request)
    {
        $user = User::all();
        if(!$user)
            return response()->json(['mensaje'=>'No se encuentran usuarios'], 404);

        return response()->json($user, 200);

        
        
    }

    /**
     * Registration of new users.
     * @param id $id
     * @return \Illuminate\Http\Response
     *
     * Swagger
     *
     * @OA\Delete(
     *      path="/api/user/delete/{id}",
     *      operationId="userDelete",
     *      tags={"Users"},
     *      summary="Delete User",
     *      description="Delete User",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id user",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(response=200, description="Ok"),
     *      @OA\Response(response=409, description="CONFLICT"),
     *      security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    //Función que se encarga de eliminar un usuario en especifico
    public function userDelete($id)
    {
        if(User::destroy($id))
            return response()->json(['message' => 'Usuario eliminado correctamente'], 200);

        return response()->json(['message' => 'Error al eliminar el usario'], 409);
    }

    /**
     * Registration of new users.
     * @param id $id
     * @return \Illuminate\Http\Response
     *
     * Swagger
     *
     * @OA\Get(
     *      path="/api/user/show/{id}",
     *      operationId="userShow",
     *      tags={"Users"},
     *      summary="Search User",
     *      description="Search User",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id user",
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
    //Función que se encarga de devolver la data de un usuario en especifico
    public function userShow($id)
    {
        $user = User::find($id);
        if (!$user) 
            return response()->json(['mensaje'=>'No se encuentra el usuario'], 404);
        
        return response()->json(User::find($id), 200);
    }
}