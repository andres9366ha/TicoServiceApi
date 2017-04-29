<?php

namespace App\Http\Controllers;

use App\Collaborator;
use App\User;
use App\Service;
use JWTAuth;
use Illuminate\Http\Request;
use DB;

class CollaboratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collaborators = Collaborator::all();
       foreach ($collaborators as $key) {
          $user = User::find($key->id_user);
          $key->user = $user->name;
          $service = Service::find($key->id_service);
          $key->service = $service->name;
        }

      return response()->json([
             'message' => 'Buscado con exito', 'Colaboradores'  => $collaborators, 'codigo' => 200
         ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->toUser();
        $collaborator = new Collaborator();
        $collaborator->id_user = $user->id;
        $collaborator->id_service = $request->input('id_service');
        $collaborator->description = $request->input('description');
        $collaborator->availability = $request->input('availability');
        $collaborator->save();
        return response()->json(['collaborator' => $collaborator], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comments = DB::table('comments')->where('id_user_collab', $id)->get();
        foreach ($comments as $key) {
          $user = User::find($key->id_user_comm);
          $key->user = $user->name;
          $key->last = $user->last_name;
        }
        $collaborator = Collaborator::find($id);
          if(!$collaborator){
            return response()->json(['message' => 'Colaborador no existente'], 404);
        }

        $user = User::find($collaborator->id_user);
        $service = Service::find($collaborator->id_service);
        $collaborator->name = $user->name;
        $collaborator->last_name = $user->last_name;
        $collaborator->phone = $user->phone;
        $collaborator->service = $service->name;

      return response()->json([
             'message' => 'Buscado con exito', 'Colaborador'  => $collaborator, 'Comentarios' => $comments,'codigo' => 200
         ]);
    }



      public function searchByService($id)
    {
        $collaborators = DB::table('collaborators')->where('id_service', $id)->get();
        foreach ($collaborators as $key) {
          $user = User::find($key->id_user);
          $key->user = $user->name;
          $key->last = $user->last_name;
        }


      return response()->json([
        'colaboradores'  => $collaborators, 'codigo' => 200]);
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
        $collaborator = Collaborator::find($id);
        if(!$collaborator){
            return response()->json(['message' => 'Colaborador no existente'], 404);
        }
        $collaborator->id_user = $request->input('id_user');
        $collaborator->id_service = $request->input('id_service');
        $collaborator->description = $request->input('description');
        $collaborator->availability = $request->input('availability');
        $collaborator->save();
        return response()->json(['collaborator' => $collaborator], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $collaborator = Collaborator::find($id);
        $collaborator->delete();
        return response()->json(['message' => 'Colaborador eliminado', 'codigo' => 200]);
    }


   public function storeFromService($id,$token)
    {
     $user = JWTAuth::toUser($token);



      $service = Service::find($id);
      $collaborator = DB::table('collaborators')->where('id_user', $user->id)->first();
      if($collaborator){
        //si el colaborador existe
        $oldColl = array('id_user' => $user->id, 'id_service' => $service->id,
            'availability' => $collaborator->availability, 'description' => $collaborator->description);
        $this->anotherColl($oldColl);
      }else {
        //si el colaborador no existe
        $collaborator = new Collaborator();
        $collaborator->id_user = $user->id;
        $collaborator->id_service = $service->id;
        $collaborator->description = '';
        $collaborator->availability = '';
        $collaborator->save();
      }

     return response()->json(['message' => 'Servicio Añadido', 'codigo' =>'201']);
    }

    public function anotherColl(array $coll){
      $collaborator = new Collaborator();
      $collaborator->id_user = $coll['id_user'];
      $collaborator->id_service = $coll['id_service'];
      $collaborator->availability = $coll['availability'];
      $collaborator->description = $coll['description'];
      $collaborator->save();
    }

}
