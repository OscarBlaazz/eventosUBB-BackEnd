<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evento_users;
use App\Helpers\JwtAuth;

class Evento_usersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { }

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
            $jwtAuth = new JwtAuth();
            $token = $request->header('Authorization', null);
            $user = $jwtAuth->checkToken($token, true);
            $val = Evento_users::where('users_id',  $user->sub)->where('evento_idEvento',$params_array['evento_idEvento'])->first();
            
            $validate = \Validator::make($params_array, [
                'evento_idEvento' => 'required'
                


            ]);

            if ($validate->fails()) {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'No se ha guardado el evento.',
                    'errors' => $validate->errors()
                ];
            } else {
                if($params_array['evento_idEvento'] != $val['evento_idEvento']){
                    $eventoU = new Evento_users();
                    $eventoU->contadorEvento  = $params_array['contadorEvento'] ;
                    $eventoU->evento_idEvento  = $params_array['evento_idEvento'];
                    $eventoU->rol_idRol = $params_array['rol_idRol'] = 2;
                    $eventoU->users_id  = $user->sub;
                    $eventoU->save();
                    $data = [
                        'code' => 200,
                        'status' => 'success',
                        'evento' => $eventoU,
                        'validacion' => $val
                    ];
                }else{
                    $data = [
                        'code' => 400,
                        'status' => 'error',
                        'message' => 'ya se encuentra participando'
                       
                    ];
                }
                
               
                
            }
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se envio ningun evento',
                'params' => $params_array
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
        $evento = Evento_users::where('evento_idEvento', '=', $id)->get()->load('users');
        if (is_object($evento)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'evento' => $evento

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


            unset($params_array[$id]);
            $eventoU = Evento_users::where('evento_idEvento', $id);
            $eventoU->contadorEvento  = $eventoU['contadorEvento'] - 1;
            $eventoU->evento_idEvento  = $id;
            $eventoU->rol_idRol = $params_array['rol_idRol'];
            $eventoU->users_id  = $user->sub;
            $eventoU->save();
            $data = [
                'code' => 200,
                'status' => 'succes',
                'evento' => $params_array
            ];
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
        $evento = Evento_users::find($id);
        if (!empty($evento)) {
            $evento->delete();

            $data = [
                'code' => 200,
                'status' => 'success',
                'evento' => $evento
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'El evento que desea borrar no existe'
            ];
        }


        return response()->json($data);
    }
    public function getEventosByUser(Request $request)
    {
        $jwtAuth = new JwtAuth();
        $token = $request->header('Authorization', null);
        $user = $jwtAuth->checkToken($token, true);
        $eventos = Evento_users::where('users_id', '=', $user->sub)->get()->load('evento');

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'eventos' => $eventos
        ]);
    }

    public function getEventosByAdmin(Request $request)
    {
        $jwtAuth = new JwtAuth();
        $token = $request->header('Authorization', null);
        $user = $jwtAuth->checkToken($token, true);
        $eventos = Evento_users::where('users_id', '=', $user->sub)->where('rol_idRol', '=', 1)->get()->load('evento');

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'eventos' => $eventos
        ]);
    }
}
