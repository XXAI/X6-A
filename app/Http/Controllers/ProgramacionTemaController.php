<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\ProgramacionTema, App\Models\Jurisdiccion, App\Models\Temas, App\Models\TipoProgramacion;
use App\Models\ProgramacionHistorial, App\Models\Verificacion, App\Models\AmbitoRiesgo, App\Models\Ejecutivo;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;

class ProgramacionTemaController extends Controller
{
    public function index(Request $request)
    {
        $parametros = $parametros = Input::only('status','q','page','per_page', 'identificador', 'jurisdiccion', 'id_tipo');

        $programacion = ProgramacionTema::with("jurisdiccion", "tipo_programacion");
        $programacion = $programacion->join("tema", "tema.id", "=", "programacion_jurisdiccion.id_tema")
                                    ->where('id_tipo_programacion', $parametros['id_tipo']) 
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
                                              DB::raw("(select count(*) from verificacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=1) as enero_acumulado"),
                                              DB::raw("(select count(*) from verificacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=2) as febrero_acumulado"),
                                              DB::raw("(select count(*) from verificacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=3) as marzo_acumulado"),
                                              DB::raw("(select count(*) from verificacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=4) as abril_acumulado"),
                                              DB::raw("(select count(*) from verificacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=5) as mayo_acumulado"),
                                              DB::raw("(select count(*) from verificacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=6) as junio_acumulado"),
                                              DB::raw("(select count(*) from verificacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=7) as julio_acumulado"),
                                              DB::raw("(select count(*) from verificacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=8) as agosto_acumulado"),
                                              DB::raw("(select count(*) from verificacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=9) as septiembre_acumulado"),
                                              DB::raw("(select count(*) from verificacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=10) as octubre_acumulado"),
                                              DB::raw("(select count(*) from verificacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=11) as noviembre_acumulado"),
                                              DB::raw("(select count(*) from verificacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null and mes=12) as diciembre_acumulado"),
                                              DB::raw("(select count(*) from verificacion where anio=programacion_jurisdiccion.anio and  id_tema=programacion_jurisdiccion.id_tema and  id_jurisdiccion=programacion_jurisdiccion.id_jurisdiccion and  deleted_at is null) as total_acumulado"));



        if ($parametros['q']) {
            $programacion =  $programacion->where(function($query) use ($parametros) {
                 $query->where('tema.descripcion','LIKE',"%".$parametros['q']."%");
             });
        }

        /*if ($parametros['jurisdiccion']) {
            $programacion =  $programacion->where('id_jurisdiccion', $parametros['jurisdiccion']);
        }*/

        /*if ($parametros['tipo']) {
            $programacion =  $programacion->where('id_tipo_programacion', $parametros['tipo_programacion']);
        }*/

        if(isset($parametros['page'])){
            $resultadosPorPagina = isset($parametros["per_page"])? $parametros["per_page"] : 25;
            $programacion = $programacion->paginate($resultadosPorPagina);
        } else {
            $programacion = $programacion->get();
        }

        return Response::json([ 'data' => $programacion],200);
    }

    public function store(Request $request)
    {
        $mensajes = [
            
            'required'      => "required"
        ];

        $reglas = [
            'id_jurisdiccion'      => 'required',
            'id_tipo_programacion'        => 'required',
            'id_tema'     => 'required',
            'enero'     => 'required',
            'febrero'     => 'required',
            'marzo'     => 'required',
            'abril'     => 'required',
            'mayo'     => 'required',
            'junio'     => 'required',
            'julio'     => 'required',
            'agosto'     => 'required',
            'septiembre'     => 'required',
            'octubre'     => 'required',
            'noviembre'     => 'required',
            'diciembre'     => 'required'
        ];

        $inputs = Input::all();

        $programacion_busqueda = ProgramacionTema::where("id_jurisdiccion", $inputs['id_jurisdiccion'])
                                                    ->where("id_tipo_programacion", $inputs['id_tipo_programacion'])
                                                    ->where("id_tema", $inputs['id_tema'])
                                                    ->where("anio", date("Y"));
        if($programacion_busqueda->count() > 0)
        {
            return Response::json(['error' => "Ya existe una programación vigente para este tema, verifique sus datos por favor"], 500);
        }                                            
        $v = Validator::make($inputs, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }
        DB::beginTransaction();
        try {
            $inputs['total'] = $inputs['enero'] + $inputs['febrero'] + $inputs['marzo'] + $inputs['abril'] + $inputs['mayo'] +  $inputs['junio'] + $inputs['julio'] + $inputs['agosto'] + $inputs['septiembre'] + $inputs['octubre'] + $inputs['noviembre'] + $inputs['diciembre'];
            $inputs['anio'] = date("Y");
            $programacion = ProgramacionTema::create($inputs);

           
            DB::commit();
            return Response::json([ 'data' => $programacion ],200);

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
            'id_jurisdiccion'      => 'required',
            'id_tipo_programacion'        => 'required',
            'id_tema'     => 'required',
            'enero'     => 'required',
            'febrero'     => 'required',
            'marzo'     => 'required',
            'abril'     => 'required',
            'mayo'     => 'required',
            'junio'     => 'required',
            'julio'     => 'required',
            'agosto'     => 'required',
            'septiembre'     => 'required',
            'octubre'     => 'required',
            'noviembre'     => 'required',
            'diciembre'     => 'required'
        ];

        $inputs = Input::all();

        

        
                                                   
        $v = Validator::make($inputs, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }
        DB::beginTransaction();
        try {

            $programacion_busqueda = ProgramacionTema::find($id);
            $arreglo_historial['id_jurisdiccion'] = $programacion_busqueda['id_jurisdiccion'];
            $arreglo_historial['id_tipo_programacion'] = $programacion_busqueda['id_tipo_programacion'];
            $arreglo_historial['id_tema'] = $programacion_busqueda['id_tema'];
            $arreglo_historial['enero'] = $programacion_busqueda['enero'];
            $arreglo_historial['febrero'] = $programacion_busqueda['febrero'];
            $arreglo_historial['marzo'] = $programacion_busqueda['marzo'];
            $arreglo_historial['abril'] = $programacion_busqueda['abril'];
            $arreglo_historial['mayo'] = $programacion_busqueda['mayo'];
            $arreglo_historial['junio'] = $programacion_busqueda['junio'];
            $arreglo_historial['julio'] = $programacion_busqueda['julio'];
            $arreglo_historial['agosto'] = $programacion_busqueda['agosto'];
            $arreglo_historial['septiembre'] = $programacion_busqueda['septiembre'];
            $arreglo_historial['octubre'] = $programacion_busqueda['octubre'];
            $arreglo_historial['noviembre'] = $programacion_busqueda['noviembre'];
            $arreglo_historial['diciembre'] = $programacion_busqueda['diciembre'];
            $arreglo_historial['total'] = $programacion_busqueda['total'];
            $arreglo_historial['anio'] = $programacion_busqueda['anio'];
            $arreglo_historial['id_programacion'] = $id;

            ProgramacionHistorial::create($arreglo_historial);

            $inputs['total'] = $inputs['enero'] + $inputs['febrero'] + $inputs['marzo'] + $inputs['abril'] + $inputs['mayo'] +  $inputs['junio'] + $inputs['julio'] + $inputs['agosto'] + $inputs['septiembre'] + $inputs['octubre'] + $inputs['noviembre'] + $inputs['diciembre'];
            unset($inputs['id_jurisdiccion']);
            unset($inputs['id_tipo_programacion']);
            unset($inputs['id_tema']);
            $programacion = $programacion_busqueda->update($inputs);

           
            DB::commit();
            return Response::json([ 'data' => $programacion ],200);

        } catch (\Exception $e) {
             DB::rollBack();
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        }
    }

    function destroy(Request $request, $id){
        try {
        	
            $promocion = ProgramacionTema::find($id);

            if($promocion)
            {
                $promocion->delete();
                return Response::json(['data'=>$promocion],200);
            }else
            {
                return Response::json(['error'=>"No tiene privilegios para eliminar este usuario"],500);
            }
        } catch (Exception $e) {
           return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        }

    }

    public function catalogos(Request $request)
    {
        $catalogos = Array();
        $parametros = Input::all();
        $jurisdiccion = Jurisdiccion::all();
        $temas = Temas::all();
        $ambito = AmbitoRiesgo::all();
        $tipoProgramacion = TipoProgramacion::all();
        $ejecutivo = Ejecutivo::all();

        if(isset($parametros['jurisdiccion']) && isset($parametros['tema']))
        {
            $verificaciones = Verificacion::where("anio", date("Y"))->where("id_jurisdiccion", $parametros['jurisdiccion'])->where("id_tema", $parametros['tema'])->get();
            $catalogos['verificaciones'] = $verificaciones;
        }
        $catalogos['jurisdiccion'] = $jurisdiccion;
        $catalogos['tema'] = $temas;
        $catalogos['tipoProgramacion'] = $tipoProgramacion;
        $catalogos['ambito'] = $ambito;
        $catalogos['ejecutivo'] = $ejecutivo;
        
        $catalogos['anio'] = date("Y");

        return Response::json([ 'data' => $catalogos],200);
    }
}
