<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\Temas;
use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;

class TemaController extends Controller
{
    public function index(Request $request)
    {
        $parametros = $parametros = Input::only('status','q','page','per_page');

        $tema = Temas::with("ambito")->orderBy("descripcion");

        $usuario = Usuario::find($request->get('usuario_id'));
        $usuario_catalogo = false;
        $permisos = [];
        
        $usuario_general = Usuario::with('roles.permisos')->find($request->get('usuario_id'));

        foreach ($usuario_general->roles as $index => $rol) {
            foreach ($rol->permisos as $permiso) {
                if($permiso->id == 'jiUvnacE7X6RwdktZhjx6w3rnNff7BBA'){ $usuario_catalogo = true; }
            }
        }
        
        if($usuario->su == 0)
        {
            if(!$usuario_catalogo)
                return Response::json(['error' => "No tiene permiso para realizar estar acción."], 500);
        }

        if ($parametros['q']) {
            $tema =  $tema->where(function($query) use ($parametros) {
                 $query->where('descripcion','LIKE',"%".$parametros['q']."%");
             });
        }
      
        if(isset($parametros['page'])){
            $resultadosPorPagina = isset($parametros["per_page"])? $parametros["per_page"] : 25;
            $tema = $tema->paginate($resultadosPorPagina);
        } else {
            $tema = $programacion->get();
        }

        return Response::json([ 'data' => $tema],200);
    }

    function destroy(Request $request, $id){
        try {
        	
            $tema = Temas::find($id);

            $usuario = Usuario::find($request->get('usuario_id'));
            $permiso_accion = false;
            $permisos = [];
        
            $usuario_general = Usuario::with('roles.permisos')->find($request->get('usuario_id'));

            foreach ($usuario_general->roles as $index => $rol) {
                foreach ($rol->permisos as $permiso) {
                    if($permiso->id == 'hxX6imSa6lZz17GKfdZFisO1QXEe7BIp'){ $permiso_accion = true; }
                }
            }

            if($usuario->su == 0)
            {
                if(!$permiso_accion)
                    return Response::json(['error' => "No tiene permiso para realizar estar acción."], 500);
            }
            if($tema)
            {
                $tema->delete();
                return Response::json(['data'=>$tema],200);
            }else
            {
                return Response::json(['error'=>"No tiene privilegios para eliminar este usuario"],500);
            }
        } catch (Exception $e) {
           return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        }

    }

    public function store(Request $request)
    {
        $mensajes = [
            
            'required'      => "required"
        ];

        $reglas = [
            'id_ambito_riesgo'      => 'required',
            'descripcion'        => 'required',
        ];

        $inputs = Input::all();

        $usuario = Usuario::find($request->get('usuario_id'));
        
        $permiso_accion = false;
        $permisos = [];
      
        $usuario_general = Usuario::with('roles.permisos')->find($request->get('usuario_id'));

        foreach ($usuario_general->roles as $index => $rol) {
            foreach ($rol->permisos as $permiso) {
                if($permiso->id == 'MBwdiwwUTOdzHkNHx7MNOUAl2q6lPECD'){ $permiso_accion = true; }
            }
        }

        if($usuario->su == 0)
        {
            if(!$permiso_accion)
                return Response::json(['error' => "No tiene permiso para realizar estar acción."], 500);
        }
          
                                                    
        $v = Validator::make($inputs, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }
        DB::beginTransaction();
        try {
            $tema = Temas::create($inputs);
            DB::commit();
            return Response::json([ 'data' => $tema ],200);
            

        } catch (\Exception $e) {
             DB::rollBack();
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        } 
    }

    public function update(Request $request, $id)
    {
        $mensajes = [
            
            'required'      => "required"
        ];

        $reglas = [
            'id_ambito_riesgo'      => 'required',
            'descripcion'        => 'required',
        ];

        $inputs = Input::all();

        $usuario = Usuario::find($request->get('usuario_id'));
        $permiso_accion = false;
        $permisos = [];
      
        $usuario_general = Usuario::with('roles.permisos')->find($request->get('usuario_id'));

        foreach ($usuario_general->roles as $index => $rol) {
            foreach ($rol->permisos as $permiso) {
                if($permiso->id == 'i4hUg8iFfw7TD3wheKgsknlDQjwBbwHJ'){ $permiso_accion = true; }
            }
        }

        if($usuario->su == 0)
        {
            if(!$permiso_accion)
                return Response::json(['error' => "No tiene permiso para realizar estar acción."], 500);
        }
                                                  
        $v = Validator::make($inputs, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }
        DB::beginTransaction();
        try {
            $tema = Temas::find($id);
            $tema = $tema->update($inputs);
           
            DB::commit();
            return Response::json([ 'data' => $tema ],200);

        } catch (\Exception $e) {
             DB::rollBack();
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        }
    }
}
