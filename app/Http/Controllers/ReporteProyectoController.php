<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\ProgramacionTema, App\Models\Usuario, App\Models\Muestra, App\Models\Verificacion, App\Models\Capacitacion, App\Models\Dictamen, App\Models\Reaccion;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;

class ReporteProyectoController extends Controller
{
    public function index(Request $request)
    {
        $parametros = $parametros = Input::only('status','q','page','per_page', 'anio', 'jurisdiccion', "tema");

        $respuesta = [];
        $datos = ProgramacionTema::with("tema")->where("anio", date("Y"))
                                   ->where("id_tema", $parametros['tema'])
                                   ->whereNull("deleted_at")
                                   ->select("id_tipo_programacion",
                                            "id_tema",    
                                            DB::RAW("(select sum(total)) as total"))
                                   ->groupBy("id_tema", "id_tipo_programacion")           
                                   ->get();

        foreach ($datos as $key => $value) {
            if($value['id_tipo_programacion'] == 1 )
            {
                $registro = Verificacion::where("anio", date("Y"))
                                    ->where("id_tema", $parametros['tema'])
                                    ->whereNull("deleted_at") 
                                    ->select(DB::RAW("count(*) as acumulado"))
                                    ->groupBy("id_tema")   
                                    ->first();
                $registro['total'] = $value['total'];                    
                $registro['id_tipo_programacion'] = $value['id_tipo_programacion'];                    
                $registro['tema'] = $value->tema['descripcion'];                    
                $registro['tipo'] = "Verificación";                    
                $respuesta[] = $registro;                    
            }
            if($value['id_tipo_programacion'] == 2 )
            {
                $registro = Muestra::where("anio", date("Y"))
                                    ->where("id_tema", $parametros['tema'])
                                    ->whereNull("deleted_at") 
                                    ->select(DB::RAW("count(*) as acumulado"),
                                            DB::RAW("(select count(*) from muestra m where m.anio=muestra.anio and m.id_tema=muestra.id_tema and deleted_at is null and especificaciones=1) as dentro_especificaciones"),
                                            DB::RAW("(select count(*) from muestra m where m.anio=muestra.anio and m.id_tema=muestra.id_tema and deleted_at is null and especificaciones=0) as fuera_especificaciones"))
                                    ->groupBy("id_tema")   
                                    ->first();
                $registro['total'] = $value['total'];                    
                $registro['id_tipo_programacion'] = $value['id_tipo_programacion']; 
                $registro['tema'] = $value->tema['descripcion']; 
                $registro['tipo'] = "Muestra";                                      
                $respuesta[] = $registro;                    
            }
            if($value['id_tipo_programacion'] == 3 )
            {
                $registro = Capacitacion::where("anio", date("Y"))
                                    ->where("id_tema", $parametros['tema'])
                                    ->whereNull("deleted_at") 
                                    ->select(DB::RAW("count(*) as acumulado"))
                                    ->groupBy("id_tema")   
                                    ->first();
                $registro['total'] = $value['total'];                    
                $registro['id_tipo_programacion'] = $value['id_tipo_programacion'];         
                $registro['tema'] = $value->tema['descripcion'];       
                $registro['tipo'] = "Capacitación";                            
                $respuesta[] = $registro;                    
            }
            if($value['id_tipo_programacion'] == 4 )
            {
                $registro = Dictamen::where("anio", date("Y"))
                                    ->where("id_tema", $parametros['tema'])
                                    ->whereNull("deleted_at") 
                                    ->select(DB::RAW("count(*) as acumulado"))
                                    ->groupBy("id_tema")   
                                    ->first();
                $registro['total'] = $value['total'];                    
                $registro['id_tipo_programacion'] = $value['id_tipo_programacion'];   
                $registro['tema'] = $value->tema['descripcion']; 
                $registro['tipo'] = "Dictamen";                                        
                $respuesta[] = $registro;                    
            }
            if($value['id_tipo_programacion'] == 5 )
            {
                $registro = Reaccion::where("anio", date("Y"))
                                    ->where("id_tema", $parametros['tema'])
                                    ->whereNull("deleted_at") 
                                    ->select(DB::RAW("count(*) as acumulado"))
                                    ->groupBy("id_tema")   
                                    ->first();
                $registro['total'] = $value['total'];                    
                $registro['id_tipo_programacion'] = $value['id_tipo_programacion'];               
                $registro['tema'] = $value->tema['descripcion'];        
                $registro['tipo'] = "Reacción Adversa";                     
                $respuesta[] = $registro;                    
            }
        }                            
        return Response::json([ 'data' => $respuesta],200);                  
    }
}
