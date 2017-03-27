<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class UserController extends Controller
{

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $user = new User([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        $user->save();
        return response()->json([
            'message' => 'Usuario creado exitosamente'
        ], 201);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        try{
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json([
                    'error' => 'Credenciales Invalidas'
                ], 401);
            }
        }catch (JWTException $e){
            return response()->json([
                'error' => 'No se ha podido crear el token'
            ], 500);
        }
        return response()->json([
            'token' => $token
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => 'Usuario no existente'], 404);
        }
        $user->phone = $request->input('phone');
        $user->password = $request->input('password');
        $user->save();
        return response()->json(['user' => $user], 200);
    }

    public function index()
    {
        $users = User::all();
        $response = [
            'users' => $users
        ];
        return response()->json($response,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => 'Usuario no existente'], 404);
        }
        return response()->json($user,200);
    }
}
