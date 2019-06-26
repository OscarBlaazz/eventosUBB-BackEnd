<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evento;
use App\Colaborador;
use App\Jornada;
use App\Expositor;
use App\Actividad;

class EventoPojoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        var_dump($params);
        die();
        if (!empty($params_array)) {
            $validate = \Validator::make($params_array, [

                'nombreEvento' => 'required'
            ]);

            if ($validate->fails()) {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'No se ha guardado el evento.',
                    'errors' => $validate->errors()
                ];
            } else {

                $evento = new Evento();
                $evento->nombreEvento  = $params_array['nombreEvento'];
                $evento->ubicacion  = $params_array['ubicacion'];
                $evento->direccion = $params_array['direccion'];
                $evento->detalles  = $params_array['detalles'];
                $evento->imagen  = $params_array['imagen'];
                $evento->capacidad  = $params_array['capacidad'];
                $evento->nombreEventoInterno = $params_array['nombreEventoInterno'];
                $evento->ciudad_idciudad = $params_array['ciudad_idciudad']; 
                $evento->save();

                $colaborador = new Colaborador();
                $colaborador->nombreColaborador = $params_array['nombreColaborador'];
                $colaborador->nombreRepresentante = $params_array['nombreRepresentante'];
                $colaborador->telefonoColaborador = $params_array['telefonoColaborador'];
                $colaborador->correoColaborador = $params_array['correoColaborador'];
                $colaborador->sitioWeb = $params_array['sitioWeb'];
                $colaborador->logo = $params_array['logo'];
                $colaborador->evento_idEvento = $evento['idEvento'];
                $colaborador->save();

                $jornada = new Jornada();
                $jornada->nombreJornada = $params_array['nombreJornada'];
                $jornada->fechaJornada = $params_array['fechaJornada'];
                $jornada->horaInicioJornada = $params_array['horaInicioJornada'];
                $jornada->horaFinJornada = $params_array['horaFinJornada'];
                $jornada->ubicacionJornada = $params_array['ubicacionJornada'];
                $jornada->descripcionJornada = $params_array['descripcionJornada'];
                $jornada->evento_idEvento = $evento['idEvento'];
                $jornada->save();

                $actividad = new Actividad();
                $actividad->nombreActividad = $params_array['nombreActividad'];
                $actividad->horaInicioActividad = $params_array['horaInicioActividad'];
                $actividad->horaFinActividad = $params_array['horaFinActividad'];
                $actividad->ubicacionActividad = $params_array['ubicacionActividad'];
                $actividad->descripcionActividad = $params_array['descripcionActividad'];
                $actividad->jornada_idJornada = $jornada['idJornada'];
                $actividad->save();

                $expositor = new Expositor();
                $expositor->nombreExpositor  = $params_array['nombreExpositor'];
                $expositor->apellidoExpositor  = $params_array['apellidoExpositor'];
                $expositor->sexo = $params_array['sexo'];
                $expositor->correoExpositor  = $params_array['correoExpositor'];
                $expositor->empresa  = $params_array['empresa'];
                $expositor->foto  = $params_array['foto'];
                $expositor->actividad_idActividad = $actividad['idActividad'];
                $expositor->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'evento' => $evento,
                    'Colaborador' => $colaborador,
                    'jornada' => $jornada,
                    'expositor' => $expositor,
                    'actividad' => $actividad
                ];
            }
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se envio ningun evento'
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
        //
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
                'nombreEvento' => 'required'
            ]);

            if ($validate->fails()) {

                $data = [
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'Error al actualizar datos'
                ];
            } else {

                unset($params_array['idEvento']);
                unset($params_array['idColaborador']);
                unset($params_array['Evento_idEvento']);

                $evento = Evento::where('idEvento', $id)->first();
                $evento->nombreEvento  = $params_array['nombreEvento'];
                $evento->ubicacionJornada  = $params_array['ubicacionJornada'];
                $evento->direccion = $params_array['direccion'];
                $evento->detalles  = $params_array['detalles'];
                $evento->imagen  = $params_array['imagen'];
                $evento->capacidad  = $params_array['capacidad'];
                $evento->save();

                $colaborador = Colaborador::where('Evento_idEvento', $id)->first();
                $colaborador->nombreColaborador = $params_array['nombreColaborador'];
                $colaborador->nombreRepresentate = $params_array['nombreRepresentate'];
                $colaborador->telefonoColaborador = $params_array['telefonoColaborador'];
                $colaborador->correoColaborador = $params_array['correoColaborador'];
                $colaborador->sitioWeb = $params_array['sitioWeb'];
                $colaborador->logo = $params_array['logo'];
                $colaborador->save();

                $jornada = Jornada::where('Evento_idEvento', $id)->first();
                $jornada->nombreJornada = $params_array['nombreJornada'];
                $jornada->fechaJornada = $params_array['fechaJornada'];
                $jornada->horaInicioJornada = $params_array['horaInicioJornada'];
                $jornada->horaFinJornada = $params_array['horaFinJornada'];
                $jornada->ubicacionJornada = $params_array['ubicacionJornada'];
                $jornada->descripcionJornada = $params_array['descripcionJornada'];
                $jornada->Evento_idEvento = $evento['idEvento'];
                $jornada->save();

                $expositor = Expositar::where('Evento_idEvento', $id)->first();
                $expositor->nombreExpositor  = $params_array['nombreExpositor'];
                $expositor->apellidoExpositor  = $params_array['apellidoExpositor'];
                $expositor->sexo = $params_array['sexo'];
                $expositor->correoExpositor  = $params_array['correoExpositor'];
                $expositor->empresa  = $params_array['empresa'];
                $expositor->foto  = $params_array['foto'];
                $expositor->save();

                $data = [
                    'code' => 200,
                    'status' => 'succes',
                    'evento' => $evento
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
        //
    }
}
