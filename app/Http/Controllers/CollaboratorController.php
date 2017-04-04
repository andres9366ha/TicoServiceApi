<?php

namespace App\Http\Controllers;

use App\Collaborator;
use JWTAuth;
use Illuminate\Http\Request;

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
        $response = [
            'collaborators' => $collaborators
        ];
        return response()->json($response,200);
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
     * @param  \App\Collaborator $collaborator
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $collaborator = Collaborator::find($id);
        if(!$collaborator){
            return response()->json(['message' => 'Colaborador no existente'], 404);
        }
        return response()->json($collaborator,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Collaborator $collaborator
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
     * @param  \App\Collaborator $collaborator
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $collaborator = Collaborator::find($id);
        $collaborator->delete();
        return response()->json(['message' => 'Colaborador eliminado']);
    }
}
