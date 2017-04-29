<?php

namespace App\Http\Controllers;

use App\Service;
use JWTAuth;
use Illuminate\Http\Request;
use DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();
        $response = [
            'services' => $services
        ];
        return response()->json(['services' => $services, 'codigo' => 200]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $token)
    {


      $user = JWTAuth::toUser($token);
      if($user->type == 'user'){
                  return response()->json(['message' => 'No tiene permisos', 'codigo' => 401]);

      }

      $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);

        $service = new Service();
        $service->name = $request->name;
        $service->description = $request->description;
        $service->save();
        return response()->json(['message' => 'Servicio Creado', 'codigo' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::find($id);
        if(!$service){
            return response()->json(['message' => 'Servicio no existente', 'codigo' => 404]);
        }
        return response()->json(['service' => $service, 'codigo' => 200]);
    }


  public function showByName($name)
    {

    $service =Service::where('name', $name)->first();

        if(!$service){
            return response()->json(['message' => 'Servicio no encontrado', 'codigo' => 404]);
        }
        return response()->json(['service' => $service, 'codigo' => 200]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $service = Service::find($id);
        if(!$service){
            return response()->json(['message' => 'Servicio no existente', 'codigo' =>'404']);
        }
        $service->name = $request->name;
        $service->description = $request->description;
        $service->save();
        return response()->json(['message' => 'Servicio Actualizado', 'service' => $service, 'codigo' =>'200']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::find($id);
        if(!$service){
            return response()->json(['message' => 'Servicio no existente', 'codigo' =>'404']);
        }
        $service->delete();
        return response()->json(['message' => 'Servicio eliminado', 'codigo' => '200']);
    }



  public function myService($token)
    {

        $user = JWTAuth::toUser($token);

         $userid =$user->id;

    $collaborator = DB::table('collaborators')->where('id_user', $userid)->get();
    return response()->json(['collaborator' => $collaborator, 'codigo' =>'200']);
//         $service = Service::find($collaborator->array[0]);
//        return response()->json(['message' => $service, 'codigo' =>'404']);
/*
        if(!$collaborator){
            return response()->json(['message' => 'No tienes servicios', 'codigo' =>'404']);
        }
        return response()->json(['message' => 'Datos encontrados', 'collaborator' => $collaborator,
                                 'service' => $service, 'codigo' => '200']); */
    }



}
