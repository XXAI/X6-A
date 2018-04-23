<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\ProgramacionTema, App\Models\Usuario, App\Models\Muestra, App\Models\Verificacion, App\Models\Capacitacion;
use App\Models\Dictamen, App\Models\Reaccion, App\Models\Ejecutivo, App\Models\TipoSeguimiento, App\Models\DictamenArchivo, App\Models\Determinacion;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;

class ReporteEjecutivoController extends Controller
{
    public function index(Request $request)
    {
        $parametros = $parametros = Input::only('status','q','page','per_page', 'anio', 'jurisdiccion', "ejecutivo");

        $respuesta = [];
        $tabla = [];

        $tabla = $this->reset_variables();
        
        $tema = Ejecutivo::find($parametros['ejecutivo']);
        $tabla[0]['tema'] = $tema->descripcion; 

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

        $datos_archivo = DictamenArchivo::whereRaw("id_dictamen in (select id from dictamen where anio='".date("Y")."' and deleted_at is null and id_tema in (select id from tema where deleted_at is null and id_ambito_riesgo in (select id from ambito_riesgo where id_ejecutivo='".$parametros['ejecutivo']."'  and deleted_at is null)))")
        ->select("id_tipo_seguimiento",
            DB::RAW("(select count(*)) as contador"))       
        ->groupBy("id_tipo_seguimiento")   
        ->get();   
        
        
        $tipo_seguimiento = TipoSeguimiento::all();

        $arreglo_detalles = Array();
        foreach ($tipo_seguimiento as $key => $value) {
            $arreglo_detalles[0][$value->descripcion] = 0;
            foreach ($datos_archivo as $key2 => $value2) {
                if($value->id == $value2->id_tipo_seguimiento)
                    $arreglo_detalles[0][$value->descripcion] = $value2->contador;
            }
        } 

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
                
                if(!$registro)
                {
                    $registro['acumulado'] = 0;
                }
                $registro['total'] = $value['total'];                    
                $registro['id_tipo_programacion'] = $value['id_tipo_programacion'];                    
                $registro['ejecutivo'] = $value['descripcion'];                    
                $registro['tipo'] = "Verificación";                    
                $respuesta[] = $registro;           
                
                $tabla[0]['verificaciones']['total'] = $value['total'];
                $tabla[0]['verificaciones']['acumulado'] = $registro['acumulado'];
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
                if(!$registro)
                {
                    $registro['acumulado'] = 0;
                    $registro['dentro_especificaciones'] = 0;
                    $registro['fuera_especificaciones'] = 0;
                }
                
                $registro['total'] = $value['total'];                    
                $registro['id_tipo_programacion'] = $value['id_tipo_programacion']; 
                $registro['ejecutivo'] = $value['descripcion']; 
                $registro['tipo'] = "Muestra";                                      
                $respuesta[] = $registro;        
                
                $tabla[0]['muestra']['total'] = $value['total'];
                $tabla[0]['muestra']['acumulado'] = $registro['acumulado'];
                
                $tabla[0]['muestra_acumulado']['dentro'] = $registro['dentro_especificaciones'];
                $tabla[0]['muestra_acumulado']['fuera'] = $registro['fuera_especificaciones'];

                $arreglo_detalles[0]['muestra_detalles'] = $registro['dentro_especificaciones'];

                
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
                if(!$registro)
                {
                    $registro['acumulado'] = 0;
                }
                $registro['total'] = $value['total'];                    
                $registro['id_tipo_programacion'] = $value['id_tipo_programacion'];         
                $registro['ejecutivo'] = $value['descripcion'];       
                $registro['tipo'] = "Capacitación";                            
                $respuesta[] = $registro;          
                
                $tabla[0]['capacitacion']['total'] = $value['total'];
                $tabla[0]['capacitacion']['acumulado'] = $registro['acumulado'];                    
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
                if(!$registro)
                {
                    $registro['acumulado'] = 0;
                }
                $registro['total'] = $value['total'];                    
                $registro['id_tipo_programacion'] = $value['id_tipo_programacion'];   
                $registro['ambito_riesgo'] = $value['descripcion']; 
                $registro['tipo'] = "Dictamen";                                        
                $respuesta[] = $registro;   
                
                $tabla[0]['dictamen']['total'] = $value['total'];
                $tabla[0]['dictamen']['acumulado'] = $registro['acumulado'];                 
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
                if(!$registro)
                {
                    $registro['acumulado'] = 0;
                }
                $registro['total'] = $value['total'];                    
                $registro['id_tipo_programacion'] = $value['id_tipo_programacion'];               
                $registro['ejecutivo'] = $value['descripcion'];        
                $registro['tipo'] = "Reacción Adversa";                     
                $respuesta[] = $registro;    
                
                $tabla[0]['reaccion']['total'] = $value['total'];
                $tabla[0]['reaccion']['acumulado'] = $registro['acumulado'];                   
            }

            if($value['id_tipo_programacion'] == 6 )
            {

                
                $registro = Determinacion::join("tema", "tema.id", "=", "determinacion.id_tema")
                                    ->join("ambito_riesgo", "ambito_riesgo.id", "=", "tema.id_ambito_riesgo")
                                    ->join("ejecutivo", "ejecutivo.id", "=", "ambito_riesgo.id_ejecutivo")
                                    ->where("anio", date("Y"))
                                    ->where("ejecutivo.id", $parametros['ejecutivo'])
                                    ->whereNull("determinacion.deleted_at")
                                    ->whereNull("tema.deleted_at") 
                                    ->whereNull("ambito_riesgo.deleted_at")  
                                    ->whereNull("ejecutivo.deleted_at")  
                                    ->select(DB::RAW("count(*) as acumulado"),
                                            DB::RAW("(select count(*) from determinacion m where m.anio=determinacion.anio and m.id_tema=determinacion.id_tema and deleted_at is null and especificaciones=1) as dentro_especificaciones"),
                                            DB::RAW("(select count(*) from determinacion m where m.anio=determinacion.anio and m.id_tema=determinacion.id_tema and deleted_at is null and especificaciones=0) as fuera_especificaciones"))
                                    ->groupBy("ejecutivo.id")   
                                    ->first();

                if(!$registro)
                {
                    $registro['acumulado'] = 0;
                    $registro['dentro_especificaciones'] = 0;
                    $registro['fuera_especificaciones'] = 0;
                }
                $registro['total'] = $value['total'];                    
                $registro['id_tipo_programacion'] = $value['id_tipo_programacion'];               
                $registro['ejecutivo'] = $value['descripcion'];        
                $registro['tipo'] = "Determinación";                     
                $respuesta[] = $registro;  
                
                $tabla[0]['determinacion']['total'] = $value['total'];
                $tabla[0]['determinacion']['acumulado'] = $registro['acumulado'];
                
                $tabla[0]['determinacion_acumulado']['dentro'] = $registro['dentro_especificaciones'];
                $tabla[0]['determinacion_acumulado']['fuera'] = $registro['fuera_especificaciones'];

                $arreglo_detalles[0]['determinacion_detalles'] = $registro['dentro_especificaciones'];
            }
        }                            
        return Response::json([  'data' => array('datos'=>$respuesta, 'table'=>$tabla, 'detalles'=>$arreglo_detalles)],200);                 
    }

    private function reset_variables()
    {
        $table = [];
        $table[0]['tema'] = ""; 
        $table[0]['muestra']['total'] = 0;
        $table[0]['muestra']['acumulado'] = 0;
        $table[0]['muestra_acumulado']['dentro'] = 0;
        $table[0]['muestra_acumulado']['fuera'] = 0;
        $table[0]['capacitacion']['total'] = 0;
        $table[0]['capacitacion']['acumulado'] = 0;
        $table[0]['dictamen']['total'] = 0;
        $table[0]['dictamen']['acumulado'] = 0;
        $table[0]['reaccion']['total'] = 0;
        $table[0]['reaccion']['acumulado'] = 0;
        $table[0]['verificaciones']['total'] = 0;
        $table[0]['verificaciones']['acumulado'] = 0;
        $table[0]['determinacion']['total'] = 0;
        $table[0]['determinacion']['acumulado'] = 0;
        $table[0]['determinacion_acumulado']['dentro'] = 0;
        $table[0]['determinacion_acumulado']['fuera'] = 0;
        return $table;
    }
}
