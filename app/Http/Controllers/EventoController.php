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
       //Recoger los datos
       $json = $request->input('json', null);
       $params_array = json_decode($json, true);

       if(!empty($params_array)){
       //validar los datos
       $validate = \Validator::make($params_array,[
           'nombre' => 'required'
       ]);

       //Guardar evento
       if($validate->fails()){
           $data = [
            'code' => 400,
            'status' => 'error',
            'message' => 'No se ha guardado el evento'
           ];
       }else {
           $evento = new Evento();
           $evento->nombre = $params_array('nombre');
           $evento->save();

           $data = [
            'code' => 200,
            'status' => 'success',
            'evento' => $evento
           ];
       }
    } else {
        $data = [
            'code' => 400,
            'status' => 'error',
            'message' => 'No se ha enviado ningun evento'
           ];
    } 
       //Devolver resultado
       return response()->json($data, $data['code']);


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
