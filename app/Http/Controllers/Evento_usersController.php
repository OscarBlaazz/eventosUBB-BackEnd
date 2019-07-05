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
    public function store(Request $request , $id)
    {
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);
        
        if (!empty($params_array)) {
            $jwtAuth = new JwtAuth();
            $token = $request->header('Authorization', null);
            $user = $jwtAuth->checkToken($token, true);
            $validate = \Validator::make($params_array, [

                'contadorEvento' => 'integer'
            ]);

            if ($validate->fails()) {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'No se ha guardado el evento.',
                    'errors' => $validate->errors()
                ];
            } else {
                $eventoU = Evento_users::where('idevento_users', $id);
                $eventoU->contadorEvento  = $eventoU['contadorEvento']-1;
                $eventoU->evento_idEvento  = $id;
                $eventoU->users_id  = $user->sub;
                $eventoU->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'evento' => $eventoU
                ];
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
                $eventoU = Evento_users::where('idevento_users', $id);
                $eventoU->contadorEvento  = $eventoU['contadorEvento']-1;
                $eventoU->evento_idEvento  = $id;
                $eventoU->rol_idRol = $params_array['rol_idRol'];
                $eventoU->users_id  = $user->sub;
                $eventoU->save();
                $data = [
                    'code' => 200,
                    'status' => 'succes',
                    'evento' => $params_array
                ];
            }
         else {
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
