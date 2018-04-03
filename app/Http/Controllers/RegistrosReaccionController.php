<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\Reaccion, App\Models\Usuario;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;

class RegistrosReaccionController extends Controller
{
    public function index(Request $request)
    {
        $parametros = $parametros = Input::only('status','q','page','per_page', 'anio', 'jurisdiccion', "tema");

        $registro = Reaccion::with("jurisdiccion", "tema", "verificacion");

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
            'reaccion'        => 'required',
            'folio'        => 'required',
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

            $directorio_destino_path = "reaccion";
            if(!isset($_FILES['file']))
            {
                return Response::json(['error' => "Debe de subir un archivo para validar el registro"], HttpResponse::HTTP_NOT_FOUND);
            }

       		$extension = explode(".", strtolower($_FILES['file']['name']));
            DB::beginTransaction();
            $parametros['nombre'] = $extension[0];
            $parametros['extension'] = $extension[1];
            $parametros['peso'] = $_FILES['file']['size'];

            $usuario = Usuario::find($request->get('usuario_id'));

            /*$privilegios = registro::where("usuario_id", $request->get('usuario_id'))->where("avance_id", $parametros['avance_id'])->first();
            
            $general = false;
            $permisos = [];
            $usuario_general = Usuario::with(['roles.permisos'=>function($permisos){
                $permisos->where('id','79B3qKuUbuEiR2qKS0CFgHy2zRWfmO4r');
            }])->find($request->get('usuario_id'));

            foreach ($usuario_general->roles as $index => $rol) {
                foreach ($rol->permisos as $permiso) {
                    $permisos[$permiso->id] = true;

                    if(count($permisos)){
                        $general = true;
                    }
                }
            }
            if(count($permisos)){
                $general = true;
            }

            if($general || $usuario->su == 1 || (isset($privilegios)  && $privilegios->agregar == "1") )
            {
                $avance_detalle = AvanceDetalles::create($parametros);

                 \Request::file('file')->move($directorio_destino_path, $avance_detalle->id.".".$extension[1]);
            }else
            {
                DB::rollBack();
                return Response::json('No tiene privilegios para realizar esta accion.', 500);
            }*/    
            $parametros['archivo'] = $extension[0].".".$extension[1];
            $registro = Reaccion::create($parametros);

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
            'reaccion'        => 'required',
            'folio'        => 'required',
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
            $registro = Reaccion::find($id);
            $directorio_destino_path = "reaccion";
            
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
    
    function destroy(Request $request, $id){
        try {
        	
            $registro = Reaccion::find($id);

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

                $registro = Reaccion::find($id);
                $extension = explode(".", strtolower($registro->archivo));
                
                $directorio_path = "reaccion";
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
}
