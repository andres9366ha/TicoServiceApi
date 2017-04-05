<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use DB;
use Mail;
use View;

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


    protected function validatorSto(array $data)
{
    return Validator::make($data, [
        'name' => 'required|max:255',
        'last_name' => 'required|max:255',
        'phone' => 'required|max:20|min:6',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|min:6|same:Confirm_password',
    ]);
}

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            // 'type' => 'user',
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = $this->validatorSto($input);


        if (!$validator->passes()){
          flash('Verifique sus datos','danger');
          return view('PaginasWeb.registro');
        }
        $user = $this->create($input)->toArray();
        $user['link'] = str_random(30);

        DB::table('user_activation')->insert(['id_user'=>$user['id'],'token'=>$user['link']]);
        Mail::send('emails.activation', $user, function($message) use ($user){
            $message->to($user['email']);
            $message->subject('Active su Cuenta para Finalizar su Registro en nuestra Aplicación');
        });

        // return response()->json([
        //     'message' => 'Usuario creado exitosamente'
        // ], 200);

        flash('Usuario creado exitosamente! Verifique su bandeja de Correos','success');
        return view('PaginasWeb.login');
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
                // return response()->json([
                //     'error' => 'Credenciales Invalidas'
                // ], 401);
                flash('Credenciales Invalidas' ,'danger');
                return view('PaginasWeb.login');

            }
        }catch (JWTException $e){
            // return response()->json([
            //     'error' => 'No se ha podido crear el token'
            // ], 500);
            flash('No se a podido crear el token' ,'danger');
            return view('PaginasWeb.login');
        }
        $datos = DB::table('users')->where('email',$request['email'])->first();
        if ($datos->is_activated ==0)
        {
            // return response()->json(['error'=>array([
            //   'code'=>422,'message'=>'Verifique su bandeja de correos para activar su cuenta.Su cuenta no esta activa'])],422);
            flash('Verifique su bandeja de correos para activar su cuenta.Su cuenta no esta activa' ,'danger');
            return view('PaginasWeb.login');
        }

        $nombre = 'Fernando';
     return View::make('PaginasWeb.busqueda')->with('nombre', $nombre);
        // return response()->json([
        //     'token' => $token
        // ], 200);
    }


    public function userActivation($token){
        $check = DB::table('user_activation')->where('token',$token)->first();
        if(!is_null($check)){

            $user = User::find($check->id_user);
            if ($user->is_activated ==1){
                // return response()->json(['error'=>array(['code'=>422,'message'=>'Su cuenta ya esta activada.No podemos activarla de nuevo'])],422);
                flash('Su cuenta ya esta activada.No podemos activarla de nuevo','warning');
                return view('PaginasWeb.login');

            }

            $user->is_activated =1;
            $user->save();
            // return response()->json(['code'=>'201','mensaje'=>'Su cuenta fue activa'],201);

            flash('Su cuenta fue activa!' ,'success');
            return view('PaginasWeb.login');
        }
        // return response()->json(['error'=>array(['code'=>422,'message'=>'Su codigo es invalido.'])],422);
        flash('Su codigo es invalido' ,'danger');
        return view('PaginasWeb.login');
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
            // return response()->json(['message' => 'Usuario no existente'], 404);
            flash('Usuario no existente' ,'danger');
            return view('PaginasWeb.login');
        }
        $user->phone = $request->input('phone');
        $user->password = $request->input('password');
        $user->save();
        // return response()->json(['user' => $user], 200);
        flash('Actualizado con exito' ,'success');
        return view('PaginasWeb.login');
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
            // return response()->json(['message' => 'Usuario no existente'], 404);
            flash('Usuario no existente' ,'danger');
            return view('PaginasWeb.login');
        }
        return response()->json($user,200);
    }
}
