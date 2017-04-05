<?php

namespace App\Http\Controllers;

use App\Service;
use JWTAuth;
use Illuminate\Http\Request;

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
        // $response = [
        //     'services' => $services
        // ];
        // return response()->json($response,200);
        return view('PaginasWeb.servicios')->with('services', $services);
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
        // if($user->type == 'user'){
        //   //impide que se muestre opción para agregar servicios
        //   dd('equals');
        // }else{
        //   dd('no equals');
        // }
        $this->validate($request, [
            'name' => 'required|unique:services',
            'description' => 'required',
        ]);

        $service = new Service();
        $service->name = $request->input('name');
        $service->description = $request->input('description');
        $service->save();
        return response()->json(['service' => $service, 'user' => $user], 201);
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
            return response()->json(['message' => 'Servicio no existente'], 404);
        }
        return response()->json($service,200);
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
            return response()->json(['message' => 'Servicio no existente'], 404);
        }
        $service->name = $request->input('name');
        $service->description = $request->input('description');
        $service->save();
        return response()->json(['service' => $service], 200);
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
        $service->delete();
        return response()->json(['message' => 'Servicio eliminado']);
    }
}
