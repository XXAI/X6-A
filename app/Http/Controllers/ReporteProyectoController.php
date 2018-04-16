<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\ProgramacionTema, App\Models\Usuario, App\Models\Muestra, App\Models\Verificacion, App\Models\Capacitacion, App\Models\Dictamen, App\Models\Reaccion, App\Models\DictamenArchivo, App\Models\TipoSeguimiento;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;

class ReporteProyectoController extends Controller
{
    public function index(Request $request)
    {
        $parametros = $parametros = Input::only('status','q','page','per_page', 'anio', 'jurisdiccion', "tema");

        $respuesta = [];
        $tabla = [];

        $tabla = $this->reset_variables();
        
        $datos = ProgramacionTema::with("tema")->where("anio", date("Y"))
                                   ->where("id_tema", $parametros['tema'])
                                   ->whereNull("deleted_at")
                                   ->select("id_tipo_programacion",
                                            "id_tema",    
                                            DB::RAW("(select sum(total)) as total"))
                                   ->groupBy("id_tema", "id_tipo_programacion")           
                                   ->get();
        
        $datos_archivo = DictamenArchivo::whereRaw("id_dictamen in (select id from dictamen where id_tema='".$parametros['tema']."' and anio='".date("Y")."' and deleted_at is null)")
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
            $tabla[0]['tema'] = $value->tema['descripcion']; 
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
                
                $tabla[0]['verificaciones']['total'] = $value['total'];
                $tabla[0]['verificaciones']['acumulado'] = $registro['acumulado'];
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
                
                $tabla[0]['muestra']['total'] = $value['total'];
                $tabla[0]['muestra']['acumulado'] = $registro['acumulado'];
                
                $tabla[0]['muestra_acumulado']['dentro'] = $registro['dentro_especificaciones'];
                $tabla[0]['muestra_acumulado']['fuera'] = $registro['fuera_especificaciones'];

                $arreglo_detalles[0]['muestra_detalles'] = $registro['dentro_especificaciones'];
                
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
                
                $tabla[0]['capacitacion']['total'] = $value['total'];
                $tabla[0]['capacitacion']['acumulado'] = $registro['acumulado'];

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
                
                $tabla[0]['dictamen']['total'] = $value['total'];
                $tabla[0]['dictamen']['acumulado'] = $registro['acumulado'];
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
                
                $tabla[0]['reaccion']['total'] = $value['total'];
                $tabla[0]['reaccion']['acumulado'] = $registro['acumulado'];
            }
        }    
                     
        return Response::json([ 'data' => array('datos'=>$respuesta, 'table'=>$tabla, 'detalles'=>$arreglo_detalles)],200);                  
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

        return $table;
    }
}
