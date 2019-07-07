<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

use App\User;

class UserController extends Controller
{
    public  function register(Request $request)
    {
        // Recoger los datos del usuario por post
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);
        $params = json_decode($json);

        if (!empty($params_array) && !empty($params)) {
            //Limpiar datos
            $params_array = array_map('trim', $params_array);

            //Validar datos
            $validate = \Validator::make($params_array, [
                'nombreUsuario' => 'required|alpha',
                'apellidoUsuario' => 'required|alpha',
                'email' => 'required|email|unique:users',
                'password' => 'required'

            ]);

            if ($validate->fails()) {
                $data = [
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'El usuario existe o tienes un campo sin llenar',
                    'errors' => $validate->errors()
                ];
            } else if (Str::contains($params_array['email'], ['gmail.com', 'hotmail.com', 'outlook.com', 'outlook.cl' ,'alumnos.ubiobio.cl']) == true) {

                //Cifrar la contraseña 
                $pwd = hash('sha256', $params->password);

                //Crear el usuario 
                $user = new User();
                $user['perfil_idPerfil'] = 2;
                $user->nombreUsuario = $params_array['nombreUsuario'];
                $user->apellidoUsuario = $params_array['apellidoUsuario'];
                $user->email = $params_array['email'];
                $user->password = $pwd;
                $user->save();
                $data = [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'El usuario  se ha creado correctamente',
                ];
            } else if (Str::contains($params_array['email'], 'ubiobio.cl') == true) {
                //Cifrar la contraseña 
                $pwd = hash('sha256', $params->password);

                //Crear el usuario 
                $user = new User();
                $user['perfil_idPerfil'] = 1;
                $user->nombreUsuario = $params_array['nombreUsuario'];
                $user->apellidoUsuario = $params_array['apellidoUsuario'];
                $user->email = $params_array['email'];
                $user->password = $pwd;
                $user->save();
                $data = [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'El usuario  se ha creado correctamente',
                ];
            }
        } else {

            $data = [
                'status' => 'error',
                'code' => 404,
                'message' => 'Los datos enviado no son correctos'
            ];
        }
        return response()->json($data);
    }


    public function google(Request $request){
        $token = $request->header('Authorization', null);
        
        $client = new Google_Client([
            'client_id' => env('GOOGLE_CLIENT_ID')
         ]);
         $payload = $client->verifyIdToken($token);
         if ($payload) {
            $user = new User();
            $user->google_id = $payload['sub'];
            $user->save();
            $data = [
                'status' => 'success',
                'code' => 200,
                'message' => 'El usuario  se ha creado correctamente',
            ];
         }else {

            $data = [
                'status' => 'error',
                'code' => 404,
                'message' => 'Los datos enviado no son correctos'
            ];
        }
        return response()->json($data);

    }

    public function login(Request $request)
    {
        $jwtAuth = new \JwtAuth();

        //Recibir post 
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);
        //Validar esos datos
        $validate = \Validator::make($params_array, [

            'email' => 'required|email',
            'password' => 'required'

        ]);

        if ($validate->fails()) {
            $signup = [
                'status' => 'error',
                'code' => 404,
                'message' => 'El usuario no se ha podido identificar',
                'errors' => $validate->errors()
            ];
        } else {
            //Cifrar contraseña
            $pwd = hash('sha256', $params->password);
            //Devolver token o datos
            $signup = $jwtAuth->signup($params->email, $pwd);
            if (!empty($params->gettoken)) {
                $signup = $jwtAuth->signup($params->email, $pwd, true);
            }
        }

        return response()->json($signup, 200);
    }

    public function update(Request $request)
    {
        //Comprobar si el usuario se encunetra identificado
        $token = $request->header('Authorization');
        $jwtAuth = new \JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);


        //Recoger los datos por post
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if ($checkToken && !empty($params_array)) {

            //Scar usuario identificado
            $user = $checkToken = $jwtAuth->checkToken($token, true);

            //validar los datos
            $validate = \Validator::make($params_array, [
                'nombreUsuario' => 'required|alpha',
                'apellidoUsuario' => 'required|alpha',
                'email' => 'required|email|unique:users' . $user->sub,
            ]);
            //quitar los campos que no quiero actualizar de la peticion
            unset($params_array['id']);
            unset($params_array['created_at']);
            unset($params_array['remember_token']);
            unset($params_array['perfil_idPerfil']);


            //actualizar usuario en bbdd
            $user_update = User::where('id', $user->sub)->update($params_array);

            //devolver un array con los resultados

            $data = [
                'code' => 200,
                'status' => 'success',
                'user' => $user,
                'changes' => $params_array
            ];
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'El usuario no se encuentra identificado'
            ];
        }
        return response()->json($data);
    }

    public function upload(Request $request)
    {
        // Recoger datos de la petición
        $image = $request->file('file0');
        // Validar imagen

        $validate = \Validator::make($request->all(), [
            'file0' => 'required|image|mimes:jpg,jpeg,png,gif'
        ]);

        //Guardar imagen 
        if (!$image || $validate->fails()) {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Error al subir imagen'
            ];
        } else {
            $image_name = time() . $image->getClientOriginalName();
            \Storage::disk('users')->put($image_name, \File::get($image));

            $data = [
                'code' => 200,
                'status' => 'success',
                'image' => $image_name
            ];
        }

        //Devolver el resultado 
        return response()->json($data);
    }

    public function getAll()
    {
        $users = User::all()->load('perfil', 'unidad');

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'users' => $users
        ]);
    }


    public function getImage($filename)
    {
        $isset = \Storage::disk('users')->exists($filename);

        if ($isset) {
            $file = \Storage::disk('users')->get($filename);
            return new Response($file, 200);
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'No existe la imagen'
            ];
        }
        return response()->json($data);
    }

    public function detail($id)
    {
        $user = User::find($id);
        if (is_object($user)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'user' => $user
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'el usuario no existe'
            ];
        }
        return response()->json($data);
    }
}
