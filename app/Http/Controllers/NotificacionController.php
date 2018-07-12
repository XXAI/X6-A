<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\Notificacion;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;

class NotificacionController extends Controller
{
    public function index(Request $request)
    {
        $parametros = $parametros = Input::only('status','q','page','per_page', 'id_area_operativa', 'id_procedimiento_notificacion');

        $registro = Notificacion::with("areaOperativa", "tipoDocumento");
        

        /*$usuario = Usuario::find($request->get('usuario_id'));

        $usuario_jurisdiccion = false;
        $usuario_tema = false;
        $usuario_tema_limitado = false;
        $usuario_capturista = false;
        $permisos = [];
        
        $usuario_general = Usuario::with('roles.permisos')->find($request->get('usuario_id'));

        foreach ($usuario_general->roles as $index => $rol) {
            foreach ($rol->permisos as $permiso) {
                if($permiso->id == 'glDZ91p5ZU3LNpetwXFzLQNRjbNCpSkQ'){ $usuario_jurisdiccion = true; }
                if($permiso->id == 'JNCmYg12f9Ja0inVDoOY8v7r20pVBEBD'){ $usuario_tema = true; }
                if($permiso->id == 'DXbuTDSJBL2L4EX5dfAvw0dyCcMqnQAU'){ $usuario_tema_limitado = true; }
                if($permiso->id == 'OHDYRToKLymGxFKepWuZ6WzdCXfCt9pF'){ $usuario_capturista = true; }
                
            }
        }

        if($usuario->su == 0)
        {
            if(!$usuario_jurisdiccion && $usuario_capturista)
                $registro = $registro->where('id_jurisdiccion',$usuario->id_jurisdiccion);
        }  */                     
         if ($parametros['q']) {
            $registro =  $registro->where(function($query) use ($parametros) {
                $query->where('establecimiento','LIKE',"%".$parametros['q']."%");
            });
        }

        if ($parametros['id_area_operativa']) {
            $registro =  $registro->where('id_area_operativa', $parametros['id_area_operativa']);
        }

        if ($parametros['id_procedimiento_notificacion']) {
            $registro =  $registro->where('id_procedimiento_notificacion', $parametros['id_procedimiento_notificacion']);
        }
        if(isset($parametros['page'])){
            $resultadosPorPagina = isset($parametros["per_page"])? $parametros["per_page"] : 25;
            $registro = $registro->paginate($resultadosPorPagina);
        } else {
            $registro = $registro->get();
        }
        return Response::json([ 'data' => $registro],200);
                        
    }

    public function show($id)
    {
        try{
            DB::beginTransaction();
            $registro = Notificacion::find($id);
            DB::commit();
            return Response::json([ 'data' => $registro ],200);

        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        }
    }

    public function store(Request $request)
    {
        $mensajes = [
            'required'      => "required",
        ];

        $reglas = [
            'no_acta'        => 'required',
            'fecha_oficio_notificar'        => 'required',
            "id_area_operativa"=> 'required',
            "id_tipo_notificacion"=> 'required', 
            "id_procedimiento_notificacion"=> 'required',
            "establecimiento"=> 'required',
            "fecha_notificacion"=> 'required',
            "id_notificador"=> 'required',
            "fecha_entrega_responsable"=> 'required'
        ];

        $parametros = Input::all();

        /*$usuario = Usuario::find($request->get('usuario_id'));

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
        {
            if(!$usuario_capturista)
                if(!$permiso_modulo)
                    return Response::json(['error' => "No tiene permiso para realizar estar acción."], 500);

            if($usuario_admin)
                return Response::json(['error' => "No tiene permiso para realizar estar acción."], 500);    
        }
        
        if($usuario->su == 0 && $usuario_limitado)
            if($usuario->id_jurisdiccion != $parametros['id_jurisdiccion'])
                return Response::json(['error' => "Ha elegido una jurisdiccion que no le corresponde, por favor no intente realizar cambios no permitidos."], 500);
        */
        $v = Validator::make($parametros, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }

        try{
            DB::beginTransaction();
            $registro = Notificacion::create($parametros);
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
            'no_acta'        => 'required',
            'fecha_oficio_notificar'        => 'required',
            "id_area_operativa"=> 'required',
            "id_tipo_notificacion"=> 'required', 
            "id_procedimiento_notificacion"=> 'required',
            "establecimiento"=> 'required',
            "fecha_notificacion"=> 'required',
            "id_notificador"=> 'required',
            "fecha_entrega_responsable"=> 'required'
        ];

        $parametros = Input::all();

        /*$usuario = Usuario::find($request->get('usuario_id'));

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

        if($usuario->su == 0)
        {
            if(!$usuario_capturista)
                if(!$permiso_modulo)
                    return Response::json(['error' => "No tiene permiso para realizar estar acción."], 500);

            if($usuario_admin)
                return Response::json(['error' => "No tiene permiso para realizar estar acción."], 500);    
        }
        
        
        if($usuario->su == 0 && $usuario_limitado)
            if($usuario->id_jurisdiccion != $parametros['id_jurisdiccion'])
                return Response::json(['error' => "Ha elegido una jurisdiccion que no le corresponde, por favor no intente realizar cambios no permitidos."], 500);
        */

        $v = Validator::make($parametros, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }

        try {
            DB::beginTransaction();
            $registro = Notificacion::find($id);
            
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
        	
            $registro = Notificacion::find($id);

            /*$usuario = Usuario::find($request->get('usuario_id'));

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
    
            if($usuario->su == 0)
            {
                if(!$usuario_capturista)
                    if(!$permiso_modulo)
                        return Response::json(['error' => "No tiene permiso para realizar estar acción."], 500);

                if($usuario_admin)
                    return Response::json(['error' => "No tiene permiso para realizar estar acción."], 500);    
            }*/
            

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
}
