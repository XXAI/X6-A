<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\ProgramacionTema, App\Models\Usuario, App\Models\Muestra;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;
class ReporteJurisdiccionalController extends Controller
{
    public function index(Request $request)
    {
        $parametros = $parametros = Input::only('status','q','page','per_page', 'anio', 'jurisdiccion', "tema");

        $respuesta = [];
        $datos = ProgramacionTema::with("jurisdiccion")
                                   ->join("tema", "tema.id", "=", "programacion_jurisdiccion.id_tema")
                                   ->where("programacion_jurisdiccion.anio", date("Y"))
                                   ->where("tema.id", $parametros['tema'])
                                   ->whereNull("tema.deleted_at")
                                   ->whereNull("programacion_jurisdiccion.deleted_at")
                                   ->select("id_jurisdiccion",  
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
                                            "tema.descripcion as descripcion")
                                   ->groupBy("programacion_jurisdiccion.id_jurisdiccion")         
                                   ->orderBy("programacion_jurisdiccion.id_jurisdiccion")         
                                   ->get();
        $respuesta = [];
        foreach ($datos as $key => $value) {
            $index = count($respuesta);
            $respuesta[$index] = $value;
            $registro = Muestra::where("anio", date("Y"))
                                    ->where("id_tema", $parametros['tema'])
                                    ->where("id_jurisdiccion", $value['id_jurisdiccion'])
                                    ->whereNull("deleted_at") 
                                    ->select(DB::RAW("(select count(*) from muestra m where m.id_tema = muestra.id_tema and m.id_jurisdiccion=muestra.id_jurisdiccion and m.anio='".date("Y")."' and m.deleted_at is null and m.mes=1) as enero_acumulado"),
                                    DB::RAW("(select count(*) from muestra m where m.id_tema = muestra.id_tema and m.id_jurisdiccion=muestra.id_jurisdiccion and m.anio='".date("Y")."' and m.deleted_at is null and m.mes=2) as febrero_acumulado"),
                                    DB::RAW("(select count(*) from muestra m where m.id_tema = muestra.id_tema and m.id_jurisdiccion=muestra.id_jurisdiccion and m.anio='".date("Y")."' and m.deleted_at is null and m.mes=3) as marzo_acumulado"),
                                    DB::RAW("(select count(*) from muestra m where m.id_tema = muestra.id_tema and m.id_jurisdiccion=muestra.id_jurisdiccion and m.anio='".date("Y")."' and m.deleted_at is null and m.mes=4) as abril_acumulado"),
                                    DB::RAW("(select count(*) from muestra m where m.id_tema = muestra.id_tema and m.id_jurisdiccion=muestra.id_jurisdiccion and m.anio='".date("Y")."' and m.deleted_at is null and m.mes=5) as mayo_acumulado"),
                                    DB::RAW("(select count(*) from muestra m where m.id_tema = muestra.id_tema and m.id_jurisdiccion=muestra.id_jurisdiccion and m.anio='".date("Y")."' and m.deleted_at is null and m.mes=6) as junio_acumulado"),
                                    DB::RAW("(select count(*) from muestra m where m.id_tema = muestra.id_tema and m.id_jurisdiccion=muestra.id_jurisdiccion and m.anio='".date("Y")."' and m.deleted_at is null and m.mes=7) as julio_acumulado"),
                                    DB::RAW("(select count(*) from muestra m where m.id_tema = muestra.id_tema and m.id_jurisdiccion=muestra.id_jurisdiccion and m.anio='".date("Y")."' and m.deleted_at is null and m.mes=8) as agosto_acumulado"),
                                    DB::RAW("(select count(*) from muestra m where m.id_tema = muestra.id_tema and m.id_jurisdiccion=muestra.id_jurisdiccion and m.anio='".date("Y")."' and m.deleted_at is null and m.mes=9) as septiembre_acumulado"),
                                    DB::RAW("(select count(*) from muestra m where m.id_tema = muestra.id_tema and m.id_jurisdiccion=muestra.id_jurisdiccion and m.anio='".date("Y")."' and m.deleted_at is null and m.mes=10) as octubre_acumulado"),
                                    DB::RAW("(select count(*) from muestra m where m.id_tema = muestra.id_tema and m.id_jurisdiccion=muestra.id_jurisdiccion and m.anio='".date("Y")."' and m.deleted_at is null and m.mes=11) as noviembre_acumulado"),
                                    DB::RAW("(select count(*) from muestra m where m.id_tema = muestra.id_tema and m.id_jurisdiccion=muestra.id_jurisdiccion and m.anio='".date("Y")."' and m.deleted_at is null and m.mes=12) as diciembre_acumulado"),
                                    DB::RAW("(select count(*) from muestra m where m.id_tema = muestra.id_tema and m.id_jurisdiccion=muestra.id_jurisdiccion and m.anio='".date("Y")."' and m.deleted_at is null) as total_acumulado"))
                                    ->groupBy("id_tema")   
                                    ->first();
                                                              
            if(count($registro) > 0)
            {    
                 
                $respuesta[$index]['enero_acumulado'] = $registro->enero_acumulado;
                $respuesta[$index]['febrero_acumulado'] = $registro->febrero_acumulado;
                $respuesta[$index]['marzo_acumulado'] = $registro->marzo_acumulado;
                $respuesta[$index]['abril_acumulado'] = $registro->abril_acumulado;
                $respuesta[$index]['mayo_acumulado'] = $registro->mayo_acumulado;
                $respuesta[$index]['junio_acumulado'] = $registro->junio_acumulado;
                $respuesta[$index]['julio_acumulado'] = $registro->julio_acumulado;
                $respuesta[$index]['agosto_acumulado'] = $registro->agosto_acumulado;
                $respuesta[$index]['septiembre_acumulado'] = $registro->septiembre_acumulado;
                $respuesta[$index]['octubre_acumulado'] = $registro->octubre_acumulado;
                $respuesta[$index]['noviembre_acumulado'] = $registro->noviembre_acumulado;
                $respuesta[$index]['diciembre_acumulado'] = $registro->diciembre_acumulado;
                $respuesta[$index]['total_acumulado'] = $registro->enero_acumulado;

            }else{
                $respuesta[$index]['enero_acumulado'] = 0;
                $respuesta[$index]['febrero_acumulado'] = 0;
                $respuesta[$index]['marzo_acumulado'] = 0;
                $respuesta[$index]['abril_acumulado'] = 0;
                $respuesta[$index]['mayo_acumulado'] = 0;
                $respuesta[$index]['junio_acumulado'] = 0;
                $respuesta[$index]['julio_acumulado'] = 0;
                $respuesta[$index]['agosto_acumulado'] = 0;
                $respuesta[$index]['septiembre_acumulado'] = 0;
                $respuesta[$index]['octubre_acumulado'] = 0;
                $respuesta[$index]['noviembre_acumulado'] = 0;
                $respuesta[$index]['diciembre_acumulado'] = 0;
                $respuesta[$index]['total_acumulado'] = 0;
            }
        }   
                                 
        return Response::json([ 'data' => $respuesta],200);                  
    }
}
