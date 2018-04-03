<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\Reaccion, App\Models\ProgramacionTema;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;


class ReaccionController extends Controller
{
    public function index(Request $request)
    {
        $parametros = $parametros = Input::only('status','q','page','per_page', 'identificador', 'jurisdiccion');

        $verificacion = ProgramacionTema::with("jurisdiccion", "tipo_programacion");
        $verificacion = $verificacion->join("tema", "tema.id", "=", "programacion_jurisdiccion.id_tema")
                                    ->where('id_tipo_programacion', 5) 
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
                                              DB::raw("(select count(*) from reaccion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=1) as enero_acumulado"),
                                              DB::raw("(select count(*) from reaccion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=2) as febrero_acumulado"),
                                              DB::raw("(select count(*) from reaccion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=3) as marzo_acumulado"),
                                              DB::raw("(select count(*) from reaccion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=4) as abril_acumulado"),
                                              DB::raw("(select count(*) from reaccion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=5) as mayo_acumulado"),
                                              DB::raw("(select count(*) from reaccion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=6) as junio_acumulado"),
                                              DB::raw("(select count(*) from reaccion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=7) as julio_acumulado"),
                                              DB::raw("(select count(*) from reaccion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=8) as agosto_acumulado"),
                                              DB::raw("(select count(*) from reaccion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=9) as septiembre_acumulado"),
                                              DB::raw("(select count(*) from reaccion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=10) as octubre_acumulado"),
                                              DB::raw("(select count(*) from reaccion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=11) as noviembre_acumulado"),
                                              DB::raw("(select count(*) from reaccion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=12) as diciembre_acumulado"),
                                              DB::raw("(select count(*) from reaccion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null) as total_acumulado"));

        if ($parametros['q']) {
            $verificacion =  $verificacion->where(function($query) use ($parametros) {
                    $query->where('descripcion','LIKE',"%".$parametros['q']."%");
                });
        }

        if ($parametros['jurisdiccion']) {
            $verificacion =  $verificacion->where('id_jurisdiccion', $parametros['jurisdiccion']);
        }
        if(isset($parametros['page'])){
            $resultadosPorPagina = isset($parametros["per_page"])? $parametros["per_page"] : 25;
            $verificacion = $verificacion->paginate($resultadosPorPagina);
        } else {
            $verificacion = $verificacion->get();
        }
        return Response::json([ 'data' => $verificacion],200);
                        
    }
}
