<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Material;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $material = Colaborador::all()->load('evento');

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'colaboradores' => $material
        ], 200);
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
        $params_array = json_decode($json, true);
        if (!empty($params_array)) {
            $validate = \Validator::make(
                $params_array,
                [
                    'nombreMaterial' => 'required',
                    'Evento_idEvento' => 'required'
                ]
            );

            if ($validate->fails()) {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'faltan datos del material'
                ];
            } else {
                //guardar datos
                $material = new Material();
                $material->nombreMaterial = $params_array['nombreMaterial'];
                $material->archivo = $params_array['archivo'];
                $material->evento_idEvento = $params_array['evento_idEvento'];

                $material->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'se guardaron los datos del material correctamente'
                ];
            }
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'Error con los datos'
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
        $material = Material::find($id)->load('evento');

        if (is_object($material)) {
            $data =
                [
                    'code' => 200,
                    'status' => 'success',
                    'colaborador' => $material
                ];
        } else {
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
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [
                'nombreMaterial' => 'required',
                'Evento_idEvento' => 'required'
            ]);

            if ($validate->fails()) {

                $data = [
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'Error al actualizar datos'
                ];
            } else {
                unset($params_array[$id]);

                $material = Material::where('idMaterial', $id)->update($params_array);

                $data = [
                    'code' => 200,
                    'status' => 'succes',
                    'material' => $params_array
                ];
            }
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'datos no actualizados'
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
        $material = Material::find($id);
        if (!empty($material)) {
            $material->delete();

            $data = [
                'code' => 200,
                'status' => 'success',
                'colaborador' => $material
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'El material que desea borrar no existe'
            ];
        }


        return response()->json($data);
    }
}
