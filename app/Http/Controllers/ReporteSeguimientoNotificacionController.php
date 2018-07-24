<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\CatalogoAreaOperativa, App\Models\CatalogoTrabajador;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;

class ReporteSeguimientoNotificacionController extends Controller
{
    public function index(Request $request)
    {
        $parametros = $parametros = Input::only('status','q','page','per_page', 'id_area_operativa');

        $filtro = "";
        $titulo_filtro = "TODOS";
        if($parametros['id_area_operativa'] != 0)
        {
            $filtro = " and registro_notificacion.id_area_operativa=".$parametros['id_area_operativa'];
            $tabla_area_operativa = CatalogoAreaOperativa::find($parametros['id_area_operativa']);
            $titulo_filtro = $tabla_area_operativa->descripcion;
        }

        $registro_area_operativa = CatalogoAreaOperativa::select("id", "descripcion",
                                            DB::RAW("(select count(*) from registro_notificacion where catalogo_area_operativa.id=registro_notificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=1) as ENERO,
                                            (select count(*) from registro_notificacion where catalogo_area_operativa.id=registro_notificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=2) as FEBRERO,
                                            (select count(*) from registro_notificacion where catalogo_area_operativa.id=registro_notificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=3) as MARZO,
                                            (select count(*) from registro_notificacion where catalogo_area_operativa.id=registro_notificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=4) as ABRIL,
                                            (select count(*) from registro_notificacion where catalogo_area_operativa.id=registro_notificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=5) as MAYO,
                                            (select count(*) from registro_notificacion where catalogo_area_operativa.id=registro_notificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=6) as JUNIO,
                                            (select count(*) from registro_notificacion where catalogo_area_operativa.id=registro_notificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=7) as JULIO,
                                            (select count(*) from registro_notificacion where catalogo_area_operativa.id=registro_notificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=8) as AGOSTO,
                                            (select count(*) from registro_notificacion where catalogo_area_operativa.id=registro_notificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=9) as SEPTIEMBRE,
                                            (select count(*) from registro_notificacion where catalogo_area_operativa.id=registro_notificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=10) as OCTUBRE,
                                            (select count(*) from registro_notificacion where catalogo_area_operativa.id=registro_notificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=11) as NOVIEMBRE,
                                            (select count(*) from registro_notificacion where catalogo_area_operativa.id=registro_notificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=12) as DICIEMBRE,
                                            (select count(*) from registro_notificacion where catalogo_area_operativa.id=registro_notificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y").") as TOTAL"));
        
        if($parametros['id_area_operativa'] != 0)
        {
            $registro_area_operativa = $registro_area_operativa->where("id", "=", $parametros['id_area_operativa']);
        }                                    

        $registro_area_operativa = $registro_area_operativa->get();

        $registro_tipo_noificacion = DB::table("registro_notificacion as rn")
                                            ->whereNull("rn.deleted_at")
                                            ->where("rn.fecha_notificacion", ">=", date("Y")."-01-01")
                                            ->select("rn.id_tipo_notificacion",
                                                    DB::RAW("(select count(*) from registro_notificacion where rn.id_tipo_notificacion=registro_notificacion.id_tipo_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=1) as ENERO,
                                                    (select count(*) from registro_notificacion where rn.id_tipo_notificacion=registro_notificacion.id_tipo_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=2) as FEBRERO,
                                                    (select count(*) from registro_notificacion where rn.id_tipo_notificacion=registro_notificacion.id_tipo_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=3) as MARZO,
                                                    (select count(*) from registro_notificacion where rn.id_tipo_notificacion=registro_notificacion.id_tipo_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=4) as ABRIL,
                                                    (select count(*) from registro_notificacion where rn.id_tipo_notificacion=registro_notificacion.id_tipo_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=5) as MAYO,
                                                    (select count(*) from registro_notificacion where rn.id_tipo_notificacion=registro_notificacion.id_tipo_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=6) as JUNIO,
                                                    (select count(*) from registro_notificacion where rn.id_tipo_notificacion=registro_notificacion.id_tipo_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=7) as JULIO,
                                                    (select count(*) from registro_notificacion where rn.id_tipo_notificacion=registro_notificacion.id_tipo_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=8) as AGOSTO,
                                                    (select count(*) from registro_notificacion where rn.id_tipo_notificacion=registro_notificacion.id_tipo_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=9) as SEPTIEMBRE,
                                                    (select count(*) from registro_notificacion where rn.id_tipo_notificacion=registro_notificacion.id_tipo_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=10) as OCTUBRE,
                                                    (select count(*) from registro_notificacion where rn.id_tipo_notificacion=registro_notificacion.id_tipo_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=11) as NOVIEMBRE,
                                                    (select count(*) from registro_notificacion where rn.id_tipo_notificacion=registro_notificacion.id_tipo_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=12) as DICIEMBRE,
                                                    (select count(*) from registro_notificacion where rn.id_tipo_notificacion=registro_notificacion.id_tipo_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y").") as TOTAL"))
                                            ->groupBy("rn.id_tipo_notificacion")
                                            ->orderBy("rn.id_tipo_notificacion", "asc")
                                            ->get();   

        $registro_procedimiento_notificacion = DB::table("registro_notificacion as rn")
                                            ->whereNull("rn.deleted_at")
                                            ->where("rn.fecha_notificacion", ">=", date("Y")."-01-01")
                                            ->select("rn.id_procedimiento_notificacion",
                                                    DB::RAW("(select count(*) from registro_notificacion where rn.id_procedimiento_notificacion=registro_notificacion.id_procedimiento_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=1) as ENERO,
                                                    (select count(*) from registro_notificacion where rn.id_procedimiento_notificacion=registro_notificacion.id_procedimiento_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=2) as FEBRERO,
                                                    (select count(*) from registro_notificacion where rn.id_procedimiento_notificacion=registro_notificacion.id_procedimiento_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=3) as MARZO,
                                                    (select count(*) from registro_notificacion where rn.id_procedimiento_notificacion=registro_notificacion.id_procedimiento_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=4) as ABRIL,
                                                    (select count(*) from registro_notificacion where rn.id_procedimiento_notificacion=registro_notificacion.id_procedimiento_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=5) as MAYO,
                                                    (select count(*) from registro_notificacion where rn.id_procedimiento_notificacion=registro_notificacion.id_procedimiento_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=6) as JUNIO,
                                                    (select count(*) from registro_notificacion where rn.id_procedimiento_notificacion=registro_notificacion.id_procedimiento_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=7) as JULIO,
                                                    (select count(*) from registro_notificacion where rn.id_procedimiento_notificacion=registro_notificacion.id_procedimiento_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=8) as AGOSTO,
                                                    (select count(*) from registro_notificacion where rn.id_procedimiento_notificacion=registro_notificacion.id_procedimiento_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=9) as SEPTIEMBRE,
                                                    (select count(*) from registro_notificacion where rn.id_procedimiento_notificacion=registro_notificacion.id_procedimiento_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=10) as OCTUBRE,
                                                    (select count(*) from registro_notificacion where rn.id_procedimiento_notificacion=registro_notificacion.id_procedimiento_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=11) as NOVIEMBRE,
                                                    (select count(*) from registro_notificacion where rn.id_procedimiento_notificacion=registro_notificacion.id_procedimiento_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=12) as DICIEMBRE,
                                                    (select count(*) from registro_notificacion where rn.id_procedimiento_notificacion=registro_notificacion.id_procedimiento_notificacion and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y").") as TOTAL"))
                                            ->groupBy("rn.id_procedimiento_notificacion")
                                            ->orderBy("rn.id_procedimiento_notificacion", "asc")
                                            ->get();                    
                                            
        $registro_notificacion_emitida = DB::table("registro_notificacion as rn")
                                            ->whereNull("rn.deleted_at")
                                            ->where("rn.fecha_notificacion", ">=", date("Y")."-01-01")
                                            ->select("rn.id",
                                                    DB::RAW("(select count(*) from registro_notificacion where deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=1) as ENERO,
                                                    (select count(*) from registro_notificacion where deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=2) as FEBRERO,
                                                    (select count(*) from registro_notificacion where deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=3) as MARZO,
                                                    (select count(*) from registro_notificacion where deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=4) as ABRIL,
                                                    (select count(*) from registro_notificacion where deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=5) as MAYO,
                                                    (select count(*) from registro_notificacion where deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=6) as JUNIO,
                                                    (select count(*) from registro_notificacion where deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=7) as JULIO,
                                                    (select count(*) from registro_notificacion where deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=8) as AGOSTO,
                                                    (select count(*) from registro_notificacion where deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=9) as SEPTIEMBRE,
                                                    (select count(*) from registro_notificacion where deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=10) as OCTUBRE,
                                                    (select count(*) from registro_notificacion where deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=11) as NOVIEMBRE,
                                                    (select count(*) from registro_notificacion where deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=12) as DICIEMBRE,
                                                    (select count(*) from registro_notificacion where deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y").") as TOTAL"))
                                            ->get();                                                        
       
        $registro_trabajador = CatalogoTrabajador::join("rel_trabajador_area_operativa", function ($join) {
                                                $join->on('catalogo_trabajador.id', '=', 'rel_trabajador_area_operativa.id_catalogo_trabajador')
                                                ->where("rel_trabajador_area_operativa.id_tipo", "=", 4);
                                            })                                            
                                            ->select("catalogo_trabajador.nombre as descripcion",
                                            DB::RAW("(select count(*) from registro_notificacion where rel_trabajador_area_operativa.id=registro_notificacion.id_notificador  and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=1) as ENERO,
                                            (select count(*) from registro_notificacion where rel_trabajador_area_operativa.id=registro_notificacion.id_notificador  and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=2) as FEBRERO,
                                            (select count(*) from registro_notificacion where rel_trabajador_area_operativa.id=registro_notificacion.id_notificador  and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=3) as MARZO,
                                            (select count(*) from registro_notificacion where rel_trabajador_area_operativa.id=registro_notificacion.id_notificador  and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=4) as ABRIL,
                                            (select count(*) from registro_notificacion where rel_trabajador_area_operativa.id=registro_notificacion.id_notificador  and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=5) as MAYO,
                                            (select count(*) from registro_notificacion where rel_trabajador_area_operativa.id=registro_notificacion.id_notificador  and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=6) as JUNIO,
                                            (select count(*) from registro_notificacion where rel_trabajador_area_operativa.id=registro_notificacion.id_notificador  and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=7) as JULIO,
                                            (select count(*) from registro_notificacion where rel_trabajador_area_operativa.id=registro_notificacion.id_notificador  and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=8) as AGOSTO,
                                            (select count(*) from registro_notificacion where rel_trabajador_area_operativa.id=registro_notificacion.id_notificador  and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=9) as SEPTIEMBRE,
                                            (select count(*) from registro_notificacion where rel_trabajador_area_operativa.id=registro_notificacion.id_notificador  and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=10) as OCTUBRE,
                                            (select count(*) from registro_notificacion where rel_trabajador_area_operativa.id=registro_notificacion.id_notificador  and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=11) as NOVIEMBRE,
                                            (select count(*) from registro_notificacion where rel_trabajador_area_operativa.id=registro_notificacion.id_notificador  and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y")." and MONTH(fecha_notificacion)=12) as DICIEMBRE,
                                            (select count(*) from registro_notificacion where rel_trabajador_area_operativa.id=registro_notificacion.id_notificador  and deleted_at is null $filtro and YEAR(fecha_notificacion)=".date("Y").") as TOTAL"));    
                                            
        if($parametros['id_area_operativa'] != 0)
        {
            
            $registro_trabajador = $registro_trabajador->where("rel_trabajador_area_operativa.id_catalogo_area_operativa", "=", $parametros['id_area_operativa']);
        }   
        $registro_trabajador = $registro_trabajador->get(); 
        
        $arreglo_respuesta = Array("Area_Operativa"=>$registro_area_operativa, "Tipo_Notificacion"=>$registro_tipo_noificacion,  "Procedimiento_Notificacion"=> $registro_procedimiento_notificacion, "Notificacion_Emitida"=> $registro_notificacion_emitida, "Trabajador"=> $registro_trabajador, "Titulo_Filtro"=> $titulo_filtro);
        return Response::json([ 'data' => $arreglo_respuesta],200);
                        
    }
}
