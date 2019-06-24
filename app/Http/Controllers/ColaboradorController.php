<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Colaborador;

class ColaboradorController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['index', 'show']]);
    }*/
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
                    'Evento_idEvento' => 'required'
                ]
            );

            if ($validate->fails()) {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'faltan datos del colaborador',
                    'errors' => $validate->errors()
                ];
            } else {
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
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'se guardaron los datos del colaborador correctamente'
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
        $colaborador = Colaborador::find($id)->load('evento');

        if (is_object($colaborador)) {
            $data =
                [
                    'code' => 200,
                    'status' => 'success',
                    'colaborador' => $colaborador
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
    { }

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

                $colaborador = Colaborador::where('idColaborador', $id)->update($params_array);

                $data = [
                    'code' => 200,
                    'status' => 'succes',
                    'colaborador' => $params_array
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
    public function destroy($id, Request $request)
    {
        $colaborador = Colaborador::find($id);
        if (!empty($colaborador)) {
            $colaborador->delete();

            $data = [
                'code' => 200,
                'status' => 'success',
                'colaborador' => $colaborador
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'El colaborador que desea borrar no existe'
            ];
        }
        return response()->json($data);
    }
    
    public function upload(Request $request)
    {
        //Recoger la imagen de la petición 
        $image = $request->file('file0');
        //Validar la imagen 
        $validate = \Validator::make($request->all(), [
            'file0' => 'required|image|mimes:jpg,jpeg,png,gif'
        ]);
        //Guardar la imagen
        if (!$image || $validate->fails()) {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Error al subir la imagen'
            ];
        } else {
            $image_name = time() . $image->getClientOriginalName();
            \Storage::disk('images')->put($image_name, \File::get($image));

            $data = [
                'code' => 200,
                'status' => 'success',
                'image' => $image_name
            ];
        }
        //Devolver datos
        return response()->json($data);
    }

    public function getImage($filename)
    {
        //Comprobar si existe el fichero
        $image = \Storage::disk('images')->exists($filename);

        if ($image) {
            //Conseguir la imagen
            $file = \Storage::disk('images')->get($filename);
            //Devolver la imagen
            return new Response($file, 200);
        } else {
            //Mostrar error
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'La imagen no existe'
            ];
            return response()->json($data);
        }
    }
    public function getEventosByCategory($id)
    {
        $evento = Colaborador::where('Evento_idEvento', $id)->get();

        return response()->json([
            'status' => 'succes',
            'evento' => $evento
        ], 200);
    }
}
