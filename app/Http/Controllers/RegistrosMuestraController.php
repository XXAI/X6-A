<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\Muestra, App\Models\Usuario;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;
class RegistrosMuestraController extends Controller
{
    public function index(Request $request)
    {
        $parametros = $parametros = Input::only('status','q','page','per_page', 'anio', 'jurisdiccion', "tema");

        $muestra = Muestra::with("jurisdiccion", "tema", "verificacion");

        if(isset($parametros['page'])){
            $resultadosPorPagina = isset($parametros["per_page"])? $parametros["per_page"] : 25;
            $muestra = $muestra->where("anio", $parametros['anio'])
                                        ->where("id_jurisdiccion", $parametros['jurisdiccion'])
                                        ->where("id_tema", $parametros['tema'])
                                        ->orderBy("mes", "desc");
            $muestra = $muestra->paginate($resultadosPorPagina);
        } else {
            $muestra = $muestra->get();
        }
        
        return Response::json([ 'data' => $muestra],200);                  
    }

    public function store(Request $request)
    {
        $mensajes = [
            'required'      => "required",
        ];

        $reglas = [
            'especificaciones'        => 'required',
            'folio'        => 'required',
            "mes"=> 'required', 
            "id_jurisdiccion"=> 'required',
            "id_tema"=> 'required', 
            "anio"=> 'required',
            "id_verificacion"=> 'required',
            
        ];

        $parametros = Input::all();

        $v = Validator::make($parametros, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }

        try {

        	$directorio_destino_path = "muestra";
            if(count($_FILES['file'])== 0)
            {
                return Response::json(['error' => "Debe se subir el archivo de soporte de actividad"], HttpResponse::HTTP_NOT_FOUND);
            }   
            $extension = explode(".", strtolower($_FILES['file']['name']));
            DB::beginTransaction();
            $parametros['nombre'] = $extension[0];
            $parametros['extension'] = $extension[1];
            $parametros['peso'] = $_FILES['file']['size'];
            
            if($_FILES['file']['size'] == 0)
            {
                return Response::json(['error' => "Debe se subir el con información"], HttpResponse::HTTP_NOT_FOUND);
            }   

            $usuario = Usuario::find($request->get('usuario_id'));

              
            $parametros['archivo'] = $extension[0].".".$extension[1];
            $parametros['folio'] = $parametros['folio'];
            $muestra = Muestra::create($parametros);

            \Request::file('file')->move($directorio_destino_path, $muestra->id.".".$extension[1]);
            DB::commit();
            return Response::json([ 'data' => $muestra ],200);

        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        }
    }

    public function update(Request $request, $id)
    {
        $mensajes = [
            'required'      => "required",
        ];

        $reglas = [
            'especificaciones'        => 'required',
            'folio'        => 'required',
            "mes"=> 'required', 
            "id_jurisdiccion"=> 'required',
            "id_tema"=> 'required', 
            "anio"=> 'required',
            "id_verificacion"=> 'required',
            
        ];

        $parametros = Input::all();

        $v = Validator::make($parametros, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }

        try {
            DB::beginTransaction();
            $muestra = Muestra::find($id);
            $directorio_destino_path = "muestra";
            
            if(isset($_FILES['file']) > 0)
            {
                $extension = explode(".", strtolower($_FILES['file']['name']));
                $parametros['nombre'] = $extension[0];
                $parametros['extension'] = $extension[1];
                $parametros['peso'] = $_FILES['file']['size'];
                $parametros['archivo'] = $extension[0].".".$extension[1];
                
                if($_FILES['file']['size'] == 0)
                {
                    return Response::json(['error' => "Debe se subir el con información"], HttpResponse::HTTP_NOT_FOUND);
                }   
                \Request::file('file')->move($directorio_destino_path, $muestra->id.".".$extension[1]);
            }   
            
            $usuario = Usuario::find($request->get('usuario_id'));
            $parametros['folio'] = $parametros['folio'];
            
            
            $muestra->update($parametros);
           
            DB::commit();
            return Response::json([ 'data' => $muestra ],200);

        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        }
    }
    

    function destroy(Request $request, $id){
        try {
        	
            $muestra = Muestra::find($id);

            if($muestra)
            {
                $muestra->delete();
                return Response::json(['data'=>$muestra],200);
            }else
            {
                return Response::json(['error'=>"No tiene privilegios para eliminar este usuario"],500);
            }
        } catch (Exception $e) {
           return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        }

    }

    public function descargar(Request $request, $id)
    {
        try{

            $variables = Input::all();

            /*$usuario = Usuario::with(['roles.permisos'=>function($permisos){
                $permisos->where('id','MrL06vIO12iNhchP14h57Puvg71eUmYb')->orWhere('id','bsIbPL3qv6XevcAyrRm1GxJufDbzLOax');
            }])->find($request->get('usuario_id'));
            
            $tiene_acceso = false;

            if(!$usuario->su){
                $permisos = [];
                foreach ($usuario->roles as $index => $rol) {
                    foreach ($rol->permisos as $permiso) {
                        $permisos[$permiso->id] = true;
                    }
                }
                if(count($permisos)){
                    $tiene_acceso = true;
                }else{
                    $tiene_acceso = false;
                }
            }else{
                $tiene_acceso = true;
            }*/
            $tiene_acceso = true;
            if($tiene_acceso){
               /*$arreglo_log = array('repositorio_id' => $id,
                            'ip' =>$request->ip(),
                            'navegador' =>$request->header('User-Agent'),
                            'accion' => 'DOWNLOAD'); 

                $log_repositorio = LogRepositorio::create($arreglo_log);

                if(!$log_repositorio)
                {
                    return Response::json(['error' => "Error al descargar el archivo"], 500); 
                }*/

                $muestra = Muestra::find($id);
                $extension = explode(".", strtolower($muestra->archivo));
                
                $directorio_path = "muestra";
                $pathToFile = $directorio_path."//".$id.".".$extension[1];
                if(file_exists($pathToFile))
                {
                    if(!file_exists($pathToFile))
                        return Response::make("No se encontro el recurso solicitado, por favor comuniquese al área de soporte", 500);
                    else
                       return Response::make(file_get_contents($pathToFile), 200, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="'.$muestra->archivo.'"'
                    ]);
                }else{
                    return Response::json(['error' =>"No se tiene acceso al recurso" ], 500);
                }
            }else{
                return Response::json(['error' =>"No tiene permisos para ingresar a este modulo" ], 500);
            }
        }catch(Exception $e){
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        }
    }
}
