<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\Dictamen, App\Models\DictamenArchivo, App\Models\Usuario;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;

class RegistrosDictamenController extends Controller
{
    public function index(Request $request)
    {
        $parametros = $parametros = Input::only('status','q','page','per_page', 'anio', 'jurisdiccion', "tema");

        $registro = Dictamen::with("jurisdiccion", "tema", "verificacion", "notificaciones", "citatorios", "resoluciones", "amonestaciones", "multas");

        if(isset($parametros['page'])){
            $resultadosPorPagina = isset($parametros["per_page"])? $parametros["per_page"] : 25;
            $registro = $registro->where("anio", $parametros['anio'])
                                        ->where("id_jurisdiccion", $parametros['jurisdiccion'])
                                        ->where("id_tema", $parametros['tema'])
                                        ->orderBy("mes", "desc");
            $registro = $registro->paginate($resultadosPorPagina);
        } else {
            $registro = $registro->get();
        }
        
        return Response::json([ 'data' => $registro],200);                  
    }

    public function store(Request $request)
    {
        $mensajes = [
            'required'      => "required",
        ];

        $reglas = [
            'oficio'        => 'required',
            "mes"=> 'required', 
            "id_jurisdiccion"=> 'required',
            "id_tema"=> 'required', 
            "anio"=> 'required',
            "id_verificacion"=> 'required'
        ];

        $parametros = Input::all();

        $v = Validator::make($parametros, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }

        try {

        	$directorio_destino_path = "dictamen";
            if(count($_FILES['file'])== 0)
            {
                return Response::json(['error' => "Debe se subir el archivo de soporte de actividad"], HttpResponse::HTTP_NOT_FOUND);
            } 
            $extension = explode(".", strtolower($_FILES['file']['name']));
            DB::beginTransaction();
            $parametros['nombre'] = $_FILES['file']['name'];
            
            $parametros['extension'] = $extension[1];
            $parametros['peso'] = $_FILES['file']['size'];
            
            if($_FILES['file']['size'] == 0)
            {
                return Response::json(['error' => "Debe se subir el con información"], HttpResponse::HTTP_NOT_FOUND);
            }   

            $usuario = Usuario::find($request->get('usuario_id'));

              
            $parametros['archivo'] = $extension[0].".".$extension[1];
            $registro = Dictamen::create($parametros);
            $directorio_destino_path .= "/".$registro->id;
            \Request::file('file')->move($directorio_destino_path, $registro->id.".".$extension[1]);
            DB::commit();
            return Response::json([ 'data' => $registro ],200);

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
            'oficio'        => 'required',
            "mes"=> 'required', 
            "id_jurisdiccion"=> 'required',
            "id_tema"=> 'required', 
            "anio"=> 'required',
            "id_verificacion"=> 'required'
        ];

        $parametros = Input::all();

        $v = Validator::make($parametros, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }

        try {
            DB::beginTransaction();
            $registro = Dictamen::find($id);
            $directorio_destino_path = "dictamen";
            
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
                \Request::file('file')->move($directorio_destino_path, $registro->id.".".$extension[1]);
            }   
            
            $usuario = Usuario::find($request->get('usuario_id'));
            
            $registro->update($parametros);
           
            DB::commit();
            return Response::json([ 'data' => $registro ],200);

        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        }
    }

    public function updatefile(Request $request, $id)
    {
        $mensajes = [
            'required'      => "required",
        ];

        $reglas = [
            'oficio'        => 'required',
            "mes"=> 'required', 
            "id_jurisdiccion"=> 'required',
            "id_tema"=> 'required', 
            "anio"=> 'required',
            "id_tipo_seguimiento"=> 'required'
        ];

        $parametros = Input::all();

        $v = Validator::make($parametros, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }

        try {
            DB::beginTransaction();
            
            $carpeta = "";
            if($parametros['id_tipo_seguimiento'] == 1)
                $carpeta = "notificacion";
            else if($parametros['id_tipo_seguimiento'] == 2)
                $carpeta = "citatorio";
            else if($parametros['id_tipo_seguimiento'] == 3)
                $carpeta = "resolucion";
            else if($parametros['id_tipo_seguimiento'] == 4)
                $carpeta = "amonestacion";
            else if($parametros['id_tipo_seguimiento'] == 5)
                $carpeta = "multa";
                
                
            
            $directorio_destino_path = "dictamen/".$carpeta;
            
            $parametros['id_dictamen'] = $id;
            if(isset($_FILES['file']))
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
                
            }else{
                return Response::json(['error' => "No se encontro archivo a subir"], HttpResponse::HTTP_NOT_FOUND);
            }
            $usuario = Usuario::find($request->get('usuario_id'));
            $registro = DictamenArchivo::create($parametros);
            \Request::file('file')->move($directorio_destino_path, $registro->id.".".$extension[1]);
            
            DB::commit();
            $registro_respuesta = DictamenArchivo::where("id_dictamen", $id)->where("id_tipo_seguimiento", $parametros['id_tipo_seguimiento'])->get();
            return Response::json([ 'data' => $registro_respuesta ],200);

        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        }
    }
    

    function destroy(Request $request, $id){
        try {
        	
            $registro = Dictamen::find($id);

            if($registro)
            {
                $registro->delete();
                return Response::json(['data'=>$registro],200);
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

                $registro = Dictamen::find($id);
                $extension = explode(".", strtolower($registro->archivo));
                
                $directorio_path = "dictamen";
                $pathToFile = $directorio_path."//".$id.".".$extension[1];
                if(file_exists($pathToFile))
                {
                    if(!file_exists($pathToFile))
                        return Response::make("No se encontro el recurso solicitado, por favor comuniquese al área de soporte", 500);
                    else
                       return Response::make(file_get_contents($pathToFile), 200, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="'.$registro->archivo.'"'
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

    public function ver(Request $request, $id)
    {
        try{

            $parametros = Input::all();

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

                $registro = DictamenArchivo::find($id);
                $carpeta = "";
                if($parametros['tipo'] == 1)
                    $carpeta = "notificacion";
                else if($parametros['tipo'] == 2)
                    $carpeta = "citatorio";
                else if($parametros['tipo'] == 3)
                    $carpeta = "resolucion";
                else if($parametros['tipo'] == 4)
                    $carpeta = "amonestacion";
                else if($parametros['tipo'] == 5)
                    $carpeta = "multa";     
                
                $directorio_path = "dictamen/".$carpeta;
                $extension = explode(".", strtolower($registro->archivo));
                
                echo $pathToFile = $directorio_path."//".$id.".".$extension[1];
                if(file_exists($pathToFile))
                {
                    if(!file_exists($pathToFile))
                        return Response::make("No se encontro el recurso solicitado, por favor comuniquese al área de soporte", 500);
                    else
                       return Response::make(file_get_contents($pathToFile), 200, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="'.$registro->archivo.'"'
                    ]);
                }else{
                    return Response::json(['error' =>"No se encontro el recurso solicitado, por favor comuniquese al área de soport" ], 500);
                }
            }else{
                return Response::json(['error' =>"No tiene permisos para ingresar a este modulo" ], 500);
            }
        }catch(Exception $e){
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        }
    }
}
