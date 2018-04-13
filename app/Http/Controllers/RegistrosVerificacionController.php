<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\Verificacion, App\Models\Usuario;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;
class RegistrosVerificacionController extends Controller
{
    public function index(Request $request)
    {
        $parametros = $parametros = Input::only('status','q','page','per_page', 'anio', 'jurisdiccion', "tema");

        $verificacion = Verificacion::with("jurisdiccion", "tema");
        $usuario = Usuario::find($request->get('usuario_id'));

        $usuario_admin = false;
        $usuario_limitado = false;
        $usuario_jurisdiccional = false;
        $usuario_capturista = false;
        $permiso_modulo = false;
        
        $usuario_general = Usuario::with('roles.permisos')->find($request->get('usuario_id'));

        foreach ($usuario_general->roles as $index => $rol) {
            foreach ($rol->permisos as $permiso) {
                if($permiso->id == 'T2i7dkAEI3I3Rp9rKipW0RHf5SYXNLqz'){ $usuario_limitado = true; }
                if($permiso->id == 'r90ysk5oy4HesbFy3bSFkjtsspVzMbAo'){ $usuario_admin = true; }
                if($permiso->id == 'csQuKy1YuGtrUnZQ5pSO2z5svinMqvZB'){ $usuario_jurisdiccional = true; }
                if($permiso->id == 'nmscPx2QPjOcF26qIHI1KS8XTuftlPCn'){ $usuario_capturista = true; }
            }
        }

        if($usuario_capturista)
        {
            $verificacion = $verificacion->where("id_jurisdiccion", $usuario->id_jurisdiccion); 
        }


        if(isset($parametros['page'])){
            $resultadosPorPagina = isset($parametros["per_page"])? $parametros["per_page"] : 25;
            $verificacion = $verificacion->where("anio", $parametros['anio'])
                                        ->where("id_jurisdiccion", $parametros['jurisdiccion'])
                                        ->where("id_tema", $parametros['tema'])
                                        ->orderBy("mes", "desc");
            $verificacion = $verificacion->paginate($resultadosPorPagina);
        } else {
            $verificacion = $verificacion->get();
        }
        
        return Response::json([ 'data' => $verificacion],200);                  
    }

    public function store(Request $request)
    {
        $mensajes = [
            'required'      => "required",
        ];

        $reglas = [
            'folio'        => 'required',
            'establecimiento'        => 'required',
            'giro'        => 'required',
            'medida_seguridad'        => 'required',
            'informativa'        => 'required',
            "mes"=> 'required', 
            "id_jurisdiccion"=> 'required',
            "id_tema"=> 'required', 
            "anio"=> 'required'
        ];

        $parametros = Input::all();
        $usuario = Usuario::find($request->get('usuario_id'));

        $usuario_admin = false;
        $usuario_limitado = false;
        $usuario_jurisdiccional = false;
        $usuario_capturista = false;
        $permiso_modulo = false;
        
        $usuario_general = Usuario::with('roles.permisos')->find($request->get('usuario_id'));
        
        foreach ($usuario_general->roles as $index => $rol) {
            foreach ($rol->permisos as $permiso) {
                if($permiso->id == 'T2i7dkAEI3I3Rp9rKipW0RHf5SYXNLqz'){ $usuario_limitado = true; }
                if($permiso->id == 'r90ysk5oy4HesbFy3bSFkjtsspVzMbAo'){ $usuario_admin = true; }
                if($permiso->id == 'csQuKy1YuGtrUnZQ5pSO2z5svinMqvZB'){ $usuario_jurisdiccional = true; }
                if($permiso->id == 'nmscPx2QPjOcF26qIHI1KS8XTuftlPCn'){ $usuario_capturista = true; }
                if($permiso->id == 'VpjLXVr2UgsbkjFqUTcokgi6d0HK8vaJ'){ $permiso_modulo = true; }
            }
        }

        if($usuario->su == 0)
            if(!$usuario_admin)
                if(!$usuario_capturista)
                    if(!$permiso_modulo)
                        return Response::json(['error' => "No tiene permiso para realizar estar acción."], 500);

        $v = Validator::make($parametros, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }

        try {
            if($parametros['mes'] > date("n"))
                return Response::json(['error' => "El mes seleccionado no debe de ser mayor al mes actual"], 500);

        	$directorio_destino_path = "verificacion";
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
            $parametros['folio_completo'] = "J".$parametros['id_jurisdiccion']."/VS".$parametros['anio']."/".$parametros['folio'];
            $parametros['establecimiento'] = strtoupper($parametros['establecimiento']);
            $parametros['giro'] = strtoupper($parametros['giro']);
            $parametros['descripcion_medida'] = strtoupper($parametros['descripcion_medida']);
            $verificacion = Verificacion::create($parametros);

            \Request::file('file')->move($directorio_destino_path, $verificacion->id.".".$extension[1]);
            DB::commit();
            return Response::json([ 'data' => $verificacion ],200);

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
            'folio'        => 'required',
            'establecimiento'        => 'required',
            'giro'        => 'required',
            'medida_seguridad'        => 'required',
            'informativa'        => 'required',
            "mes"=> 'required', 
            "id_jurisdiccion"=> 'required',
            "id_tema"=> 'required', 
            "anio"=> 'required'
        ];

        $parametros = Input::all();

        $v = Validator::make($parametros, $reglas, $mensajes);

        $usuario = Usuario::find($request->get('usuario_id'));

        $usuario_admin = false;
        $usuario_limitado = false;
        $usuario_jurisdiccional = false;
        $usuario_capturista = false;
        $permiso_modulo = false;
        
        $usuario_general = Usuario::with('roles.permisos')->find($request->get('usuario_id'));

        foreach ($usuario_general->roles as $index => $rol) {
            foreach ($rol->permisos as $permiso) {
                if($permiso->id == 'T2i7dkAEI3I3Rp9rKipW0RHf5SYXNLqz'){ $usuario_limitado = true; }
                if($permiso->id == 'r90ysk5oy4HesbFy3bSFkjtsspVzMbAo'){ $usuario_admin = true; }
                if($permiso->id == 'csQuKy1YuGtrUnZQ5pSO2z5svinMqvZB'){ $usuario_jurisdiccional = true; }
                if($permiso->id == 'nmscPx2QPjOcF26qIHI1KS8XTuftlPCn'){ $usuario_capturista = true; }
                if($permiso->id == 'oliApJdTJLV5UcgUvGA7zvt7lNeUh4Q2'){ $permiso_modulo = true; }
            }
        }

        if(!$permiso_modulo)
        {
            return Response::json(['error' => "No tiene permiso para realizar estar acción."], 500);
        }
        
        if($usuario->su == 0 && $usuario_admin)
            if($usuario->id_jurisdiccion != $parametros['id_jurisdiccion'])
                return Response::json(['error' => "Ha elegido una jurisdiccion que no le corresponde, por favor no intente realizar cambios no permitidos."], 500);
        

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }

        try {
            DB::beginTransaction();
            if($parametros['mes'] > date("n"))
                return Response::json(['error' => "El mes seleccionado no debe de ser mayor al mes actual"], 500);
            
            $verificacion = Verificacion::find($id);

            $directorio_destino_path = "verificacion";
            
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
                \Request::file('file')->move($directorio_destino_path, $verificacion->id.".".$extension[1]);
            }   
            $usuario = Usuario::find($request->get('usuario_id'));

            $parametros['folio'] = $parametros['folio'];
            $parametros['folio_completo'] = "J".$parametros['id_jurisdiccion']."/VS".date("Y")."/".$parametros['folio'];
            $parametros['establecimiento'] = strtoupper($parametros['establecimiento']);
            $parametros['giro'] = strtoupper($parametros['giro']);
            $parametros['descripcion_medida'] = strtoupper($parametros['descripcion_medida']);
                        
            $verificacion->update($parametros);
           
            DB::commit();
            return Response::json([ 'data' => $verificacion ],200);

        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        }
    }
    

    function destroy(Request $request, $id){
        try {
        	
            $verificacion = Verificacion::find($id);

            $usuario = Usuario::find($request->get('usuario_id'));

            $usuario_admin = false;
            $usuario_limitado = false;
            $usuario_jurisdiccional = false;
            $usuario_capturista = false;
            $permiso_modulo = false;
            
            $usuario_general = Usuario::with('roles.permisos')->find($request->get('usuario_id'));
    
            foreach ($usuario_general->roles as $index => $rol) {
                foreach ($rol->permisos as $permiso) {
                    if($permiso->id == 'T2i7dkAEI3I3Rp9rKipW0RHf5SYXNLqz'){ $usuario_limitado = true; }
                    if($permiso->id == 'r90ysk5oy4HesbFy3bSFkjtsspVzMbAo'){ $usuario_admin = true; }
                    if($permiso->id == 'csQuKy1YuGtrUnZQ5pSO2z5svinMqvZB'){ $usuario_jurisdiccional = true; }
                    if($permiso->id == 'nmscPx2QPjOcF26qIHI1KS8XTuftlPCn'){ $usuario_capturista = true; }
                    if($permiso->id == 'gihDKPxwrDNVqNoZ9XAKDQqP8AHj5UCJ'){ $permiso_modulo = true; }
                }
            }
    
            if(!$permiso_modulo)
            {
                return Response::json(['error' => "No tiene permiso para realizar estar acción."], 500);
            }
            
            if($verificacion)
            {
                $verificacion->delete();
                return Response::json(['data'=>$verificacion],200);
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

                $verificacion = Verificacion::find($id);
                $extension = explode(".", strtolower($verificacion->archivo));
                
                $directorio_path = "verificacion";
                $pathToFile = $directorio_path."//".$id.".".$extension[1];
                if(file_exists($pathToFile))
                {
                    
                    if(!file_exists($pathToFile))
                        return Response::make("No se encontro el recurso solicitado, por favor comuniquese al área de soporte", 500);
                    else
                       return Response::make(file_get_contents($pathToFile), 200, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="'.$verificacion->archivo.'"'
                    ]);
                    //return response()->download($pathToFile, $verificacion->archivo, $headers);
                }else{
                    return Response::json(['error' =>"No se encontro el recurso solicitado, por favor comuniquese al área de soporte" ], 500);
                }
            }else{
                return Response::json(['error' =>"No tiene permisos para ingresar a este modulo" ], 500);
            }
        }catch(Exception $e){
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        }
    }
}
