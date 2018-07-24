<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\CatalogoGiro;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;

class ReporteSeguimientoPublicidadController extends Controller
{
    public function index(Request $request)
    {
        $parpmetros = $parpmetros = Input::only('status','q','page','per_page', 'id_area_operptiva');

        $filtro = "";
        $titulo_filtro = "TODOS";
        if($parpmetros['id_area_operptiva'] != 0)
        {
            //$filtro = " and registro_publicidad.id_area_operptiva=".$parpmetros['id_area_operptiva'];
            //$tabla_area_operptiva = CatalogoAreaOperptiva::find($parpmetros['id_area_operptiva']);
            //$titulo_filtro = $tabla_area_operptiva->descripcion;
        }


        
        $registro_medio = DB::table("registro_publicidad as rp")
        ->whereNull("rp.deleted_at")
        ->where("rp.fecha_emision", ">=", date("Y")."-01-01")
        ->select("rp.id_medio_utilizado",
                DB::RAW("(select count(*) from registro_publicidad where rp.id_medio_utilizado=registro_publicidad.id_medio_utilizado and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=1) as ENERO,
                (select count(*) from registro_publicidad where rp.id_medio_utilizado=registro_publicidad.id_medio_utilizado and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=2) as FEBRERO,
                (select count(*) from registro_publicidad where rp.id_medio_utilizado=registro_publicidad.id_medio_utilizado and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=3) as MARZO,
                (select count(*) from registro_publicidad where rp.id_medio_utilizado=registro_publicidad.id_medio_utilizado and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=4) as ABRIL,
                (select count(*) from registro_publicidad where rp.id_medio_utilizado=registro_publicidad.id_medio_utilizado and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=5) as MAYO,
                (select count(*) from registro_publicidad where rp.id_medio_utilizado=registro_publicidad.id_medio_utilizado and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=6) as JUNIO,
                (select count(*) from registro_publicidad where rp.id_medio_utilizado=registro_publicidad.id_medio_utilizado and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=7) as JULIO,
                (select count(*) from registro_publicidad where rp.id_medio_utilizado=registro_publicidad.id_medio_utilizado and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=8) as AGOSTO,
                (select count(*) from registro_publicidad where rp.id_medio_utilizado=registro_publicidad.id_medio_utilizado and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=9) as SEPTIEMBRE,
                (select count(*) from registro_publicidad where rp.id_medio_utilizado=registro_publicidad.id_medio_utilizado and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=10) as OCTUBRE,
                (select count(*) from registro_publicidad where rp.id_medio_utilizado=registro_publicidad.id_medio_utilizado and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=11) as NOVIEMBRE,
                (select count(*) from registro_publicidad where rp.id_medio_utilizado=registro_publicidad.id_medio_utilizado and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=12) as DICIEMBRE,
                (select count(*) from registro_publicidad where rp.id_medio_utilizado=registro_publicidad.id_medio_utilizado and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y").") as TOTAL"))
        ->groupBy("rp.id_medio_utilizado")
        ->orderBy("rp.id_medio_utilizado", "asc")
        ->get();   

        $registro_dictamen = DB::table("registro_publicidad as rp")
        ->whereNull("rp.deleted_at")
        ->where("rp.fecha_emision", ">=", date("Y")."-01-01")
        ->select("rp.id_dictamen",
                DB::RAW("(select count(*) from registro_publicidad where rp.id_dictamen=registro_publicidad.id_dictamen and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=1) as ENERO,
                (select count(*) from registro_publicidad where rp.id_dictamen=registro_publicidad.id_dictamen and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=2) as FEBRERO,
                (select count(*) from registro_publicidad where rp.id_dictamen=registro_publicidad.id_dictamen and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=3) as MARZO,
                (select count(*) from registro_publicidad where rp.id_dictamen=registro_publicidad.id_dictamen and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=4) as ABRIL,
                (select count(*) from registro_publicidad where rp.id_dictamen=registro_publicidad.id_dictamen and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=5) as MAYO,
                (select count(*) from registro_publicidad where rp.id_dictamen=registro_publicidad.id_dictamen and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=6) as JUNIO,
                (select count(*) from registro_publicidad where rp.id_dictamen=registro_publicidad.id_dictamen and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=7) as JULIO,
                (select count(*) from registro_publicidad where rp.id_dictamen=registro_publicidad.id_dictamen and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=8) as AGOSTO,
                (select count(*) from registro_publicidad where rp.id_dictamen=registro_publicidad.id_dictamen and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=9) as SEPTIEMBRE,
                (select count(*) from registro_publicidad where rp.id_dictamen=registro_publicidad.id_dictamen and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=10) as OCTUBRE,
                (select count(*) from registro_publicidad where rp.id_dictamen=registro_publicidad.id_dictamen and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=11) as NOVIEMBRE,
                (select count(*) from registro_publicidad where rp.id_dictamen=registro_publicidad.id_dictamen and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=12) as DICIEMBRE,
                (select count(*) from registro_publicidad where rp.id_dictamen=registro_publicidad.id_dictamen and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y").") as TOTAL"))
        ->groupBy("rp.id_dictamen")
        ->orderBy("rp.id_dictamen", "asc")
        ->get();   

        $registro_medida_seguridad = DB::table("registro_publicidad as rp")
        ->whereNull("rp.deleted_at")
        ->where("rp.fecha_emision", ">=", date("Y")."-01-01")
        ->select("rp.id_medida_seguridad",
                DB::RAW("(select count(*) from registro_publicidad where rp.id_medida_seguridad=registro_publicidad.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=1) as ENERO,
                (select count(*) from registro_publicidad where rp.id_medida_seguridad=registro_publicidad.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=2) as FEBRERO,
                (select count(*) from registro_publicidad where rp.id_medida_seguridad=registro_publicidad.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=3) as MARZO,
                (select count(*) from registro_publicidad where rp.id_medida_seguridad=registro_publicidad.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=4) as ABRIL,
                (select count(*) from registro_publicidad where rp.id_medida_seguridad=registro_publicidad.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=5) as MAYO,
                (select count(*) from registro_publicidad where rp.id_medida_seguridad=registro_publicidad.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=6) as JUNIO,
                (select count(*) from registro_publicidad where rp.id_medida_seguridad=registro_publicidad.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=7) as JULIO,
                (select count(*) from registro_publicidad where rp.id_medida_seguridad=registro_publicidad.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=8) as AGOSTO,
                (select count(*) from registro_publicidad where rp.id_medida_seguridad=registro_publicidad.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=9) as SEPTIEMBRE,
                (select count(*) from registro_publicidad where rp.id_medida_seguridad=registro_publicidad.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=10) as OCTUBRE,
                (select count(*) from registro_publicidad where rp.id_medida_seguridad=registro_publicidad.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=11) as NOVIEMBRE,
                (select count(*) from registro_publicidad where rp.id_medida_seguridad=registro_publicidad.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=12) as DICIEMBRE,
                (select count(*) from registro_publicidad where rp.id_medida_seguridad=registro_publicidad.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y").") as TOTAL"))
        ->groupBy("rp.id_medida_seguridad")
        ->orderBy("rp.id_medida_seguridad", "asc")
        ->get();   

        $registro_resolucion = DB::table("registro_publicidad as rp")
        ->whereNull("rp.deleted_at")
        ->where("rp.fecha_emision", ">=", date("Y")."-01-01")
        ->select("rp.id_resolucion_administrativa",
                DB::RAW("(select count(*) from registro_publicidad where rp.id_resolucion_administrativa=registro_publicidad.id_resolucion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=1) as ENERO,
                (select count(*) from registro_publicidad where rp.id_resolucion_administrativa=registro_publicidad.id_resolucion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=2) as FEBRERO,
                (select count(*) from registro_publicidad where rp.id_resolucion_administrativa=registro_publicidad.id_resolucion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=3) as MARZO,
                (select count(*) from registro_publicidad where rp.id_resolucion_administrativa=registro_publicidad.id_resolucion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=4) as ABRIL,
                (select count(*) from registro_publicidad where rp.id_resolucion_administrativa=registro_publicidad.id_resolucion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=5) as MAYO,
                (select count(*) from registro_publicidad where rp.id_resolucion_administrativa=registro_publicidad.id_resolucion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=6) as JUNIO,
                (select count(*) from registro_publicidad where rp.id_resolucion_administrativa=registro_publicidad.id_resolucion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=7) as JULIO,
                (select count(*) from registro_publicidad where rp.id_resolucion_administrativa=registro_publicidad.id_resolucion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=8) as AGOSTO,
                (select count(*) from registro_publicidad where rp.id_resolucion_administrativa=registro_publicidad.id_resolucion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=9) as SEPTIEMBRE,
                (select count(*) from registro_publicidad where rp.id_resolucion_administrativa=registro_publicidad.id_resolucion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=10) as OCTUBRE,
                (select count(*) from registro_publicidad where rp.id_resolucion_administrativa=registro_publicidad.id_resolucion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=11) as NOVIEMBRE,
                (select count(*) from registro_publicidad where rp.id_resolucion_administrativa=registro_publicidad.id_resolucion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=12) as DICIEMBRE,
                (select count(*) from registro_publicidad where rp.id_resolucion_administrativa=registro_publicidad.id_resolucion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y").") as TOTAL"))
        ->groupBy("rp.id_resolucion_administrativa")
        ->orderBy("rp.id_resolucion_administrativa", "asc")
        ->get();

        $registro_sancion = DB::table("registro_publicidad as rp")
        ->whereNull("rp.deleted_at")
        ->where("rp.fecha_emision", ">=", date("Y")."-01-01")
        ->select("rp.id_sancion_administrativa",
                DB::RAW("(select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=1) as ENERO,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=2) as FEBRERO,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=3) as MARZO,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=4) as ABRIL,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=5) as MAYO,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=6) as JUNIO,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=7) as JULIO,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=8) as AGOSTO,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=9) as SEPTIEMBRE,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=10) as OCTUBRE,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=11) as NOVIEMBRE,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=12) as DICIEMBRE,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y").") as TOTAL"))
        ->groupBy("rp.id_sancion_administrativa")
        ->orderBy("rp.id_sancion_administrativa", "asc")
        ->get();

        $registro_informes = DB::table("registro_publicidad as rp")
        ->whereNull("rp.deleted_at")
        ->where("rp.fecha_emision", ">=", date("Y")."-01-01")
        ->select(
                DB::RAW("(select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=1) as ENERO,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=2) as FEBRERO,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=3) as MARZO,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=4) as ABRIL,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=5) as MAYO,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=6) as JUNIO,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=7) as JULIO,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=8) as AGOSTO,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=9) as SEPTIEMBRE,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=10) as OCTUBRE,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=11) as NOVIEMBRE,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y")." and MONTH(fecha_emision)=12) as DICIEMBRE,
                (select count(*) from registro_publicidad where rp.id_sancion_administrativa=registro_publicidad.id_sancion_administrativa and deleted_at is null $filtro and YEAR(fecha_emision)=".date("Y").") as TOTAL"))
        ->get();
                                            
        
        
        $arpeglo_respuesta = Array( "Medio"=> $registro_medio, "Dictamen"=>$registro_dictamen, "Medida_Seguridad"=>$registro_medida_seguridad, "Resolucion"=>$registro_resolucion, "Sancion"=>$registro_sancion, "Informe"=>$registro_informes , "Titulo_Filtro"=> $titulo_filtro);
        return Response::json([ 'data' => $arpeglo_respuesta],200);
                        
    }
}
