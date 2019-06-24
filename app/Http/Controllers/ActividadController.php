<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actividad;

class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actividad = Actividad::all()->load('jornada', 'expositor');

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'actividad' => $actividad
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
        $params = json_decode($json);
        if (!empty($params_array)) {
            $validate = \Validator::make(
                $params_array,
                [
                    'nombre' => 'required',
                    'Jornada_idJornada' => 'required',
                    'Expositor_idExpositor'
                ]
            );

            if ($validate->fails()) {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'faltan datos de la actividad',
                    'errors' => $validate->errors()
                ];
            } else {
                //guardar datos
                $actividad = new Actividad();
                $actividad->nombre = $params->nombre;
                $actividad->horaInicio = $params->horaInicio;
                $actividad->horaFin = $params->horaFin;
                $actividad->ubicacion = $params->ubicacion;
                $actividad->descripcion = $params->descripcion;
                $actividad->Jornada_idJornada = $params->Jornada_idJornada;
                $actividad->Expositor_idExpositor = $params->Expositor_idExpositor;

                $actividad->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'se guardaron los datos de la actividad correctamente'
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
        $actividad = Actividad::find($id)->load('jornada', 'expositor');

        if (is_object($actividad)) {
            $data =
                [
                    'code' => 200,
                    'status' => 'success',
                    'colaborador' => $actividad
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
                'nombre' => 'required',
                'Jornada_idJornada' => 'required',
                'Expositor_idExpositor'
            ]);

            if ($validate->fails()) {

                $data = [
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'Error al actualizar datos',
                    'errors' => $validate->errors()

                ];
            } else {
                unset($params_array[$id]);

                $actividad = Actividad::where('idActividad', $id)->update($params_array);

                $data = [
                    'code' => 200,
                    'status' => 'succes',
                    'actividad' => $params_array
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
        $actividad = Actividad::find($id);
        if (!empty($actividad)) {
            $actividad->delete();

            $data = [
                'code' => 200,
                'status' => 'success',
                'actividad' => $actividad
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'La actividad que desea borrar no existe'
            ];
        }
        return response()->json($data);
    }
}
