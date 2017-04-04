<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use DB;
use Mail;

class UserController extends Controller
{


  protected $redirectTo = '/home';

  
    public function index()
    {
        $users = User::all();
        $response = [
            'users' => $users
        ];
        return response()->json($response,200);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => 'user',
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);
        $user = $this->create($input)->toArray();
        $user['link'] = str_random(30);

        DB::table('user_activation')->insert(['id_user'=>$user['id'],'token'=>$user['link']]);
        Mail::send('emails.activation', $user, function($message) use ($user){
            $message->to($user['email']);
            $message->subject('Active su Cuenta para Finalizar su Registro en nuestra Aplicación');
        });

        return response()->json([
            'message' => 'Usuario creado exitosamente'
        ], 200);
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
        $datos = DB::table('users')->where('email',$request['email'])->first();
        if ($datos->is_activated ==0)
        {
            return response()->json(['error'=>array(['code'=>422,'message'=>'Verifique su bandeja de correos para activar su cuenta.Su cuenta no esta activa'])],422);

        }
        return response()->json([
            'token' => $token
        ], 200);
    }


    public function userActivation($token){
        $check = DB::table('user_activation')->where('token',$token)->first();
        if(!is_null($check)){

            $user = User::find($check->id_user);
            if ($user->is_activated ==1){
                return response()->json(['error'=>array(['code'=>422,'message'=>'Su cuenta ya esta activada.No podemos activarla de nuevo'])],422);
                // return redirect()->to('login')->with('success',"user are already actived.");

            }
            // var_dump('no activado');die();
            // $user->update(['is_activated' => 1]);
            $user->is_activated =1;
            $user->save();
            // DB::table('user_activations')->where('token',$token)->delete();
            return response()->json(['code'=>'201','mensaje'=>'Su cuenta fue activa'],201);

            // return redirect()->to('login')->with('success',"user active successfully.");
        }
        return response()->json(['error'=>array(['code'=>422,'message'=>'Su codigo es invalido.'])],422);
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
