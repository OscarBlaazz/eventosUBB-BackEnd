<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Colaborador;


class ColaboradorController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colaborador = Colaborador::all()->load('evento');

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'colaboradores' => $colaborador
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $params_array =json_decode($json, true);
        $params =json_decode($json);
        if(!empty($params_array))
        {
            $validate = \Validator::make($params_array, 
            [
                'nombre' => 'required',
                'Evento_idEvento' => 'required'
            ]);

            if($validate->fails())
            {
                $data = [
                    'code'=>400,
                    'status'=>'error',
                    'message'=>'faltan datos del colaborador'
                ];
            }else {
                
            }
            //guardar datos
            $colaborador = new Colaborador();
            $colaborador->nombre = $params->nombre;
            $colaborador->nombreRepresentate = $params->nombreRepresentate;
            $colaborador->telefono = $params->telefono;
            $colaborador->correo = $params->correo;
            $colaborador->sitioWeb = $params->sitioWeb;
            $colaborador->logo = $params->logo;
            $colaborador->Evento_idEvento = $params->Evento_idEvento;

            $colaborador->save();

            $data = [
                'code'=>200,
                'status'=>'success',
                'message'=>'se guardaron los datos del colaborador correctamente'
            ];

        }else{
            $data = [
                'code'=>404,
                'status'=>'error',
                'message'=>'Error con los datos'
            ];
        }
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $colaborador = Colaborador::find($id)->load('evento');

        if(is_object($colaborador))
        {
            $data = 
            [
                'code' => 200,
                'status' => 'success',
                'colaborador' => $colaborador
            ];
        }else {
            $data = 
            [
                'code' => 404,
                'status' => 'error',
                'message' => 'La entrada no existe'
            ];
        }
        return response()->json($data);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
