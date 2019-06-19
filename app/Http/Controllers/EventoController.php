<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Evento;
class EventoController extends Controller
{
/*
    public function __construct() {
        $this->middleware('api.auth', ['except' => ['index','show']]);
    }
      
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eventos = Evento::all();

        return response()->json([
            'code'=> 200,
            'status' => 'success',
            'eventos' => $eventos
        ]);
    }
    public function show($id){
        $evento = Evento::find($id);

        if(is_object($evento)){
            $data = [
                'code'=> 200,
                'status' => 'success',
                'evento' => $evento
            ];
        }else {
            $data = [
                'code'=> 404,
                'status' => 'error',
                'message' => 'El evento no existe'
            ];
        }

        return response()->json($data, $data['code']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        
            $evento = new Evento ();
    
        $evento->idevento = $request ->idevento;
        $evento->nombre  = $request ->nombre;
        $evento->ubicacion  = $request ->ubicacion;
        $evento->direccion = $request ->direccion;
        $evento->detalles  = $request->detalles;
        $evento->imagen  = $request->imagen;
        $evento->capacidad  = $request->capacidad;
        $evento -> save();

        return "Ya paso por todo, nose si guardo";
    


    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
