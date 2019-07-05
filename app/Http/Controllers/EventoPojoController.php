<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evento;
use App\Colaborador;
use App\Jornada;
use App\Expositor;
use App\Actividad;
use App\Material;
use App\Evento_users;
use App\Helpers\JwtAuth;
use Illuminate\Support\Facades\DB;

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
    
        if (!empty($params_array)) {
            $jwtAuth = new JwtAuth();
            $token = $request->header('Authorization', null);
            $user = $jwtAuth->checkToken($token, true);

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
                $evento->ciudad_idCiudad = $params_array['ciudad_idCiudad']; 
                $evento->save();

                $eventoU = new Evento_users();
                $eventoU->contadorEvento  = $evento['capacidad'];
                $eventoU->evento_idEvento  = $evento['idEvento'];
                $eventoU->users_id  = $user->sub;
                $eventoU->save();

                $material = new Material();
                $material->nombreMaterial = $params_array['nombreMaterial'];
                $material->archivo = $params_array['archivo'];
                $material->evento_idEvento = $evento['idEvento'];
                $material->save();

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

                $expositor = new Expositor();
                $expositor->nombreExpositor  = $params_array['nombreExpositor'];
                $expositor->apellidoExpositor  = $params_array['apellidoExpositor'];
                $expositor->sexo = $params_array['sexo'];
                $expositor->correoExpositor  = $params_array['correoExpositor'];
                $expositor->empresa  = $params_array['empresa'];
                $expositor->foto  = $params_array['foto'];
                $expositor->save();

                $actividad = new Actividad();
                $actividad->nombreActividad = $params_array['nombreActividad'];
                $actividad->horaInicioActividad = $params_array['horaInicioActividad'];
                $actividad->horaFinActividad = $params_array['horaFinActividad'];
                $actividad->ubicacionActividad = $params_array['ubicacionActividad'];
                $actividad->descripcionActividad = $params_array['descripcionActividad'];
                $actividad->jornada_idJornada = $jornada['idJornada'];
                $actividad->expositor_idExpositor = $expositor['idExpositor'];
                $actividad->save();


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
       $evento = Evento::find($id)->load('ciudad');
       $material = Material::where('evento_idEvento', '=' , $id )->first();
       $colaborador = Colaborador::where('evento_idEvento', '=' , $id )->first();
       $jornada = Jornada::where('evento_idEvento', '=' , $id )->first();
       $actividad = Actividad::where('jornada_idJornada', '=' , $jornada['idJornada'])->first();
       $expositor = Expositor::where('idExpositor', '=' , $actividad['expositor_idExpositor'])->first();
      


        if (is_object($evento)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'evento' => $evento , 
                'material' => $material , 
                'colaborador'=>$colaborador,
                'Jornada' => $jornada,
                'actividad' => $actividad,
                'expositor' => $expositor
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'El evento no existe'
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
            $jwtAuth = new JwtAuth();
            $token = $request->header('Authorization', null);
            $user = $jwtAuth->checkToken($token, true);
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
                $evento->ubicacion  = $params_array['ubicacion'];
                $evento->direccion = $params_array['direccion'];
                $evento->detalles  = $params_array['detalles'];
                $evento->imagen  = $params_array['imagen'];
                $evento->capacidad  = $params_array['capacidad'];
                $evento->nombreEventoInterno = $params_array['nombreEventoInterno'];
                $evento->save();

                $eventoU = new Evento_users();
                $eventoU->contadorEvento  = $evento['capacidad'];
                $eventoU->evento_idEvento  = $evento['idEvento'];
                $eventoU->users_id  = $user->sub;
                $eventoU->save();

                $material = Material::where('evento_idEvento', $id)->first();
                $material->nombreMaterial = $params_array['nombreMaterial'];
                $material->archivo = $params_array['archivo'];
                $material->save();

                $colaborador = Colaborador::where('evento_idEvento', $id)->first();
                $colaborador->nombreColaborador = $params_array['nombreColaborador'];
                $colaborador->nombreRepresentante = $params_array['nombreRepresentante'];
                $colaborador->telefonoColaborador = $params_array['telefonoColaborador'];
                $colaborador->correoColaborador = $params_array['correoColaborador'];
                $colaborador->sitioWeb = $params_array['sitioWeb'];
                $colaborador->logo = $params_array['logo'];
                $colaborador->save();

                $jornada = Jornada::where('evento_idEvento', $id)->first();
                $jornada->nombreJornada = $params_array['nombreJornada'];
                $jornada->fechaJornada = $params_array['fechaJornada'];
                $jornada->horaInicioJornada = $params_array['horaInicioJornada'];
                $jornada->horaFinJornada = $params_array['horaFinJornada'];
                $jornada->ubicacionJornada = $params_array['ubicacionJornada'];
                $jornada->descripcionJornada = $params_array['descripcionJornada'];
                $jornada->save();


                $actividad = Actividad::where('jornada_idJornada', $jornada['idJornada'])->first();
                $actividad->nombreActividad = $params_array['nombreActividad'];
                $actividad->horaInicioActividad = $params_array['horaInicioActividad'];
                $actividad->horaFinActividad = $params_array['horaFinActividad'];
                $actividad->ubicacionActividad = $params_array['ubicacionActividad'];
                $actividad->descripcionActividad = $params_array['descripcionActividad'];
                $actividad->save();


                $expositor = Expositor::where('idExpositor', $actividad['expositor_idExpositor'])->first();
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
                    'evento' => $evento,
                    'material' => $material,
                    'colaborador' => $colaborador,
                    'jornada' => $jornada,
                    'actividad'=>$actividad,
                    'expositor' =>$expositor
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
