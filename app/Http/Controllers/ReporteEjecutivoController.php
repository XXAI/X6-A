<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\ProgramacionTema, App\Models\Usuario, App\Models\Muestra, App\Models\Verificacion, App\Models\Capacitacion, App\Models\Dictamen, App\Models\Reaccion;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;

class ReporteEjecutivoController extends Controller
{
    public function index(Request $request)
    {
        $parametros = $parametros = Input::only('status','q','page','per_page', 'anio', 'jurisdiccion', "ejecutivo");

        $respuesta = [];
        $datos = ProgramacionTema::join("tema", "tema.id", "=", "programacion_jurisdiccion.id_tema")
                                   ->join("ambito_riesgo", "ambito_riesgo.id", "=", "tema.id_ambito_riesgo")
                                   ->join("ejecutivo", "ejecutivo.id", "=", "ambito_riesgo.id_ejecutivo")
                                   ->where("programacion_jurisdiccion.anio", date("Y"))
                                   ->where("ejecutivo.id", $parametros['ejecutivo'])
                                   ->whereNull("tema.deleted_at")
                                   ->whereNull("programacion_jurisdiccion.deleted_at")
                                   ->whereNull("ejecutivo.deleted_at")
                                   ->select("id_tipo_programacion",   
                                            "ejecutivo.descripcion as descripcion",    
                                            DB::RAW("(select sum(total)) as total"))
                                   ->groupBy("programacion_jurisdiccion.id_tipo_programacion")         
                                   ->get();

        foreach ($datos as $key => $value) {
            if($value['id_tipo_programacion'] == 1 )
            {
                $registro = Verificacion::join("tema", "tema.id", "=", "verificacion.id_tema")
                                    ->join("ambito_riesgo", "ambito_riesgo.id", "=", "tema.id_ambito_riesgo")
                                    ->join("ejecutivo", "ejecutivo.id", "=", "ambito_riesgo.id_ejecutivo")
                                    ->where("anio", date("Y"))
                                    ->where("ejecutivo.id", $parametros['ejecutivo'])
                                    ->whereNull("verificacion.deleted_at") 
                                    ->whereNull("tema.deleted_at") 
                                    ->whereNull("ambito_riesgo.deleted_at") 
                                    ->whereNull("ejecutivo.deleted_at") 
                                    ->select(DB::RAW("count(*) as acumulado"))
                                    ->groupBy("ejecutivo.id")   
                                    ->first();
                $registro['total'] = $value['total'];                    
                $registro['id_tipo_programacion'] = $value['id_tipo_programacion'];                    
                $registro['ejecutivo'] = $value['descripcion'];                    
                $registro['tipo'] = "Verificación";                    
                $respuesta[] = $registro; 
                //return Response::json([ 'data' => $registro],200);                      
            }
            if($value['id_tipo_programacion'] == 2 )
            {
                $registro = Muestra::join("tema", "tema.id", "=", "muestra.id_tema")
                                    ->join("ambito_riesgo", "ambito_riesgo.id", "=", "tema.id_ambito_riesgo")
                                    ->join("ejecutivo", "ejecutivo.id", "=", "ambito_riesgo.id_ejecutivo")
                                    ->where("anio", date("Y"))
                                    ->where("ejecutivo.id", $parametros['ejecutivo'])
                                    ->whereNull("muestra.deleted_at") 
                                    ->whereNull("tema.deleted_at") 
                                    ->whereNull("ambito_riesgo.deleted_at") 
                                    ->whereNull("ejecutivo.deleted_at") 
                                    ->select(DB::RAW("count(*) as acumulado"),
                                            DB::RAW("(select count(*) from muestra m where m.anio=muestra.anio and m.id_tema=muestra.id_tema and deleted_at is null and especificaciones=1) as dentro_especificaciones"),
                                            DB::RAW("(select count(*) from muestra m where m.anio=muestra.anio and m.id_tema=muestra.id_tema and deleted_at is null and especificaciones=0) as fuera_especificaciones"))
                                    ->groupBy("ejecutivo.id")   
                                    ->first();
                $registro['total'] = $value['total'];                    
                $registro['id_tipo_programacion'] = $value['id_tipo_programacion']; 
                $registro['ejecutivo'] = $value['descripcion']; 
                $registro['tipo'] = "Muestra";                                      
                $respuesta[] = $registro;                    
            }
            if($value['id_tipo_programacion'] == 3 )
            {
                $registro = Capacitacion::join("tema", "tema.id", "=", "capacitacion.id_tema")
                                    ->join("ambito_riesgo", "ambito_riesgo.id", "=", "tema.id_ambito_riesgo")
                                    ->join("ejecutivo", "ejecutivo.id", "=", "ambito_riesgo.id_ejecutivo")
                                    ->where("anio", date("Y"))
                                    ->where("ejecutivo.id", $parametros['ejecutivo'])
                                    ->whereNull("capacitacion.deleted_at") 
                                    ->whereNull("tema.deleted_at") 
                                    ->whereNull("ambito_riesgo.deleted_at") 
                                    ->whereNull("ejecutivo.deleted_at") 
                                    ->select(DB::RAW("count(*) as acumulado"))
                                    ->groupBy("ejecutivo.id")   
                                    ->first();
                $registro['total'] = $value['total'];                    
                $registro['id_tipo_programacion'] = $value['id_tipo_programacion'];         
                $registro['ejecutivo'] = $value['descripcion'];       
                $registro['tipo'] = "Capacitación";                            
                $respuesta[] = $registro;                    
            }
            if($value['id_tipo_programacion'] == 4 )
            {
                $registro = Dictamen::join("tema", "tema.id", "=", "dictamen.id_tema")
                                    ->join("ambito_riesgo", "ambito_riesgo.id", "=", "tema.id_ambito_riesgo")
                                    ->join("ejecutivo", "ejecutivo.id", "=", "ambito_riesgo.id_ejecutivo")
                                    ->where("anio", date("Y"))
                                    ->where("ejecutivo.id", $parametros['ejecutivo'])
                                    ->whereNull("dictamen.deleted_at")
                                    ->whereNull("tema.deleted_at") 
                                    ->whereNull("ambito_riesgo.deleted_at")  
                                    ->select(DB::RAW("count(*) as acumulado"))
                                    ->groupBy("ejecutivo.id")   
                                    ->first();
                $registro['total'] = $value['total'];                    
                $registro['id_tipo_programacion'] = $value['id_tipo_programacion'];   
                $registro['ejecutivo'] = $value['descripcion']; 
                $registro['tipo'] = "Dictamen";                                        
                $respuesta[] = $registro;                    
            }
            if($value['id_tipo_programacion'] == 5 )
            {
                $registro = Reaccion::join("tema", "tema.id", "=", "reaccion.id_tema")
                                    ->join("ambito_riesgo", "ambito_riesgo.id", "=", "tema.id_ambito_riesgo")
                                    ->join("ejecutivo", "ejecutivo.id", "=", "ambito_riesgo.id_ejecutivo")
                                    ->where("anio", date("Y"))
                                    ->where("ejecutivo.id", $parametros['ejecutivo'])
                                    ->whereNull("reaccion.deleted_at")
                                    ->whereNull("tema.deleted_at") 
                                    ->whereNull("ambito_riesgo.deleted_at")  
                                    ->whereNull("ejecutivo.deleted_at")  
                                    ->select(DB::RAW("count(*) as acumulado"))
                                    ->groupBy("ejecutivo.id")   
                                    ->first();
                $registro['total'] = $value['total'];                    
                $registro['id_tipo_programacion'] = $value['id_tipo_programacion'];               
                $registro['ejecutivo'] = $value['descripcion'];        
                $registro['tipo'] = "Reacción Adversa";                     
                $respuesta[] = $registro;                    
            }
        }                            
        return Response::json([ 'data' => $respuesta],200);                  
    }
}
