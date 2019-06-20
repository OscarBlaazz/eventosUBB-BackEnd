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

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $json = $request->input('json', null);
      $params_array = json_decode($json, true);

      if(!empty($params_array)){
        $validate= \Validator::make($params_array,[

            'nombre' => 'required'
        ]);

        if ($validate->fails()) {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se ha guardado el evento.' 
            ];
        }else {
            $evento = new Evento ();
            $evento->nombre  = $params_array['nombre'];
            $evento->ubicacion  = $params_array['ubicacion'];
            $evento->direccion = $params_array['direccion'];
            $evento->detalles  = $params_array['detalles'];
            $evento->imagen  = $params_array['imagen'];
            $evento->capacidad  = $params_array['capacidad'];
            $evento -> save();

            $data = [
                'code' => 200,
                'status' => 'success',
                'evento' => $evento 
            ];
        }
      }else {
        $data = [
            'code' => 400,
            'status' => 'error',
            'message' => 'No se envio ningun evento' 
        ];
    }
    return response()->json($data);
      /*  
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
    

*/
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
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if(!empty($params_array)){
            //validar
            $validate = \Validator::make($params_array, [

                'nombre' => 'required'
            ]);

            //quitar lo que no quiero actualizar
            unset($params_array[$id]);

            //Actualizar el registro de evento
            $evento = Evento::where('idevento', $id)->update($params_array);
            
            $data = [
                'code' => 200,
                'status' => 'success',
                'category' => $params_array
            ];

        }else {
            
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se actualizo ningun evento' 
            ];
        }

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }


}
