<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\Determinacion, App\Models\ProgramacionTema, App\Models\Usuario;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;

class DeterminacionController extends Controller
{
    public function index(Request $request)
    {
        $parametros = $parametros = Input::only('status','q','page','per_page', 'identificador', 'jurisdiccion');

        $registro = ProgramacionTema::with("jurisdiccion", "tipo_programacion");
        $registro = $registro->join("tema", "tema.id", "=", "programacion_jurisdiccion.id_tema")
                                    ->where('id_tipo_programacion', 6) 
                                     ->select("programacion_jurisdiccion.id",
                                              "tema.descripcion",
                                              "anio",
                                              "id_jurisdiccion",
                                              "id_tema",
                                              "id_tipo_programacion",
                                              "enero",
                                              "febrero",
                                              "marzo",
                                              "abril",
                                              "mayo",
                                              "junio",
                                              "julio",
                                              "agosto",
                                              "septiembre",
                                              "octubre",
                                              "noviembre",
                                              "diciembre",
                                              "total",
                                              DB::raw("(select count(*) from determinacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=1) as enero_acumulado"),
                                              DB::raw("(select count(*) from determinacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=2) as febrero_acumulado"),
                                              DB::raw("(select count(*) from determinacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=3) as marzo_acumulado"),
                                              DB::raw("(select count(*) from determinacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=4) as abril_acumulado"),
                                              DB::raw("(select count(*) from determinacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=5) as mayo_acumulado"),
                                              DB::raw("(select count(*) from determinacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=6) as junio_acumulado"),
                                              DB::raw("(select count(*) from determinacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=7) as julio_acumulado"),
                                              DB::raw("(select count(*) from determinacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=8) as agosto_acumulado"),
                                              DB::raw("(select count(*) from determinacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=9) as septiembre_acumulado"),
                                              DB::raw("(select count(*) from determinacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=10) as octubre_acumulado"),
                                              DB::raw("(select count(*) from determinacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=11) as noviembre_acumulado"),
                                              DB::raw("(select count(*) from determinacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=12) as diciembre_acumulado"),
                                              DB::raw("(select count(*) from determinacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null) as total_acumulado"));

        $usuario = Usuario::find($request->get('usuario_id'));

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
        }                       
        if ($parametros['q']) {
            $registro =  $registro->where(function($query) use ($parametros) {
                    $query->where('descripcion','LIKE',"%".$parametros['q']."%");
                });
        }

        if ($parametros['jurisdiccion']) {
            $registro =  $registro->where('id_jurisdiccion', $parametros['jurisdiccion']);
        }
        if(isset($parametros['page'])){
            $resultadosPorPagina = isset($parametros["per_page"])? $parametros["per_page"] : 25;
            $registro = $registro->paginate($resultadosPorPagina);
        } else {
            $registro = $registro->get();
        }
        return Response::json([ 'data' => $registro],200);
                        
    }
}
