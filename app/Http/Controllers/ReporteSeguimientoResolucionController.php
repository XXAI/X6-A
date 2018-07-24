<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\CatalogoAreaOperativa, App\Models\CatalogoGiro, App\Models\CatalogoTrabajador, App\Models\CatalogoEstatusDocumento;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;

class ReporteSeguimientoResolucionController extends Controller
{
    public function index(Request $request)
    {
        $parametros = $parametros = Input::only('status','q','page','per_page', 'id_area_operativa');

        $filtro = "";
        $titulo_filtro = "TODOS";
        if($parametros['id_area_operativa'] != 0)
        {
            $filtro = " and registro_resolucion.id_area_operativa=".$parametros['id_area_operativa'];
            $tabla_area_operativa = CatalogoAreaOperativa::find($parametros['id_area_operativa']);
            $titulo_filtro = $tabla_area_operativa->descripcion;
        }


        
        $registro_estatus_documento = CatalogoEstatusDocumento::where("id_tipo",3)  
                                            ->select("id", "descripcion",
                                            DB::RAW("(select count(*) from registro_resolucion where catalogo_estatus_documento.id=registro_resolucion.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=1) as ENERO,
                                            (select count(*) from registro_resolucion where catalogo_estatus_documento.id=registro_resolucion.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=2) as FEBRERO,
                                            (select count(*) from registro_resolucion where catalogo_estatus_documento.id=registro_resolucion.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=3) as MARZO,
                                            (select count(*) from registro_resolucion where catalogo_estatus_documento.id=registro_resolucion.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=4) as ABRIL,
                                            (select count(*) from registro_resolucion where catalogo_estatus_documento.id=registro_resolucion.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=5) as MAYO,
                                            (select count(*) from registro_resolucion where catalogo_estatus_documento.id=registro_resolucion.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=6) as JUNIO,
                                            (select count(*) from registro_resolucion where catalogo_estatus_documento.id=registro_resolucion.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=7) as JULIO,
                                            (select count(*) from registro_resolucion where catalogo_estatus_documento.id=registro_resolucion.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=8) as AGOSTO,
                                            (select count(*) from registro_resolucion where catalogo_estatus_documento.id=registro_resolucion.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=9) as SEPTIEMBRE,
                                            (select count(*) from registro_resolucion where catalogo_estatus_documento.id=registro_resolucion.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=10) as OCTUBRE,
                                            (select count(*) from registro_resolucion where catalogo_estatus_documento.id=registro_resolucion.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=11) as NOVIEMBRE,
                                            (select count(*) from registro_resolucion where catalogo_estatus_documento.id=registro_resolucion.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=12) as DICIEMBRE,
                                            (select count(*) from registro_resolucion where catalogo_estatus_documento.id=registro_resolucion.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y").") as TOTAL"))
                                            ->get();
       
        $registro_area_operativa = CatalogoAreaOperativa::select("id", "descripcion",
                                            DB::RAW("(select count(*) from registro_resolucion where catalogo_area_operativa.id=registro_resolucion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=1) as ENERO,
                                            (select count(*) from registro_resolucion where catalogo_area_operativa.id=registro_resolucion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=2) as FEBRERO,
                                            (select count(*) from registro_resolucion where catalogo_area_operativa.id=registro_resolucion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=3) as MARZO,
                                            (select count(*) from registro_resolucion where catalogo_area_operativa.id=registro_resolucion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=4) as ABRIL,
                                            (select count(*) from registro_resolucion where catalogo_area_operativa.id=registro_resolucion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=5) as MAYO,
                                            (select count(*) from registro_resolucion where catalogo_area_operativa.id=registro_resolucion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=6) as JUNIO,
                                            (select count(*) from registro_resolucion where catalogo_area_operativa.id=registro_resolucion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=7) as JULIO,
                                            (select count(*) from registro_resolucion where catalogo_area_operativa.id=registro_resolucion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=8) as AGOSTO,
                                            (select count(*) from registro_resolucion where catalogo_area_operativa.id=registro_resolucion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=9) as SEPTIEMBRE,
                                            (select count(*) from registro_resolucion where catalogo_area_operativa.id=registro_resolucion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=10) as OCTUBRE,
                                            (select count(*) from registro_resolucion where catalogo_area_operativa.id=registro_resolucion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=11) as NOVIEMBRE,
                                            (select count(*) from registro_resolucion where catalogo_area_operativa.id=registro_resolucion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=12) as DICIEMBRE,
                                            (select count(*) from registro_resolucion where catalogo_area_operativa.id=registro_resolucion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y").") as TOTAL"));
        
        if($parametros['id_area_operativa'] != 0)
        {
            $registro_area_operativa = $registro_area_operativa->where("id", "=", $parametros['id_area_operativa']);
        }                                    

        $registro_area_operativa = $registro_area_operativa->get();

        $registro_recurso = DB::table("registro_resolucion as rr")
                                            ->whereNull("rr.deleted_at")
                                            ->where("rr.fecha_recepcion", ">=", date("Y")."-01-01")
                                            ->select("rr.id_recurso_inconformidad",
                                                    DB::RAW("(select count(*) from registro_resolucion where rr.id_recurso_inconformidad=registro_resolucion.id_recurso_inconformidad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=1) as ENERO,
                                                    (select count(*) from registro_resolucion where rr.id_recurso_inconformidad=registro_resolucion.id_recurso_inconformidad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=2) as FEBRERO,
                                                    (select count(*) from registro_resolucion where rr.id_recurso_inconformidad=registro_resolucion.id_recurso_inconformidad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=3) as MARZO,
                                                    (select count(*) from registro_resolucion where rr.id_recurso_inconformidad=registro_resolucion.id_recurso_inconformidad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=4) as ABRIL,
                                                    (select count(*) from registro_resolucion where rr.id_recurso_inconformidad=registro_resolucion.id_recurso_inconformidad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=5) as MAYO,
                                                    (select count(*) from registro_resolucion where rr.id_recurso_inconformidad=registro_resolucion.id_recurso_inconformidad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=6) as JUNIO,
                                                    (select count(*) from registro_resolucion where rr.id_recurso_inconformidad=registro_resolucion.id_recurso_inconformidad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=7) as JULIO,
                                                    (select count(*) from registro_resolucion where rr.id_recurso_inconformidad=registro_resolucion.id_recurso_inconformidad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=8) as AGOSTO,
                                                    (select count(*) from registro_resolucion where rr.id_recurso_inconformidad=registro_resolucion.id_recurso_inconformidad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=9) as SEPTIEMBRE,
                                                    (select count(*) from registro_resolucion where rr.id_recurso_inconformidad=registro_resolucion.id_recurso_inconformidad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=10) as OCTUBRE,
                                                    (select count(*) from registro_resolucion where rr.id_recurso_inconformidad=registro_resolucion.id_recurso_inconformidad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=11) as NOVIEMBRE,
                                                    (select count(*) from registro_resolucion where rr.id_recurso_inconformidad=registro_resolucion.id_recurso_inconformidad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=12) as DICIEMBRE,
                                                    (select count(*) from registro_resolucion where rr.id_recurso_inconformidad=registro_resolucion.id_recurso_inconformidad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y").") as TOTAL"))
                                            ->groupBy("rr.id_recurso_inconformidad")
                                            ->orderBy("rr.id_recurso_inconformidad", "asc")
                                            ->get();   

        $registro_sancion = DB::table("registro_resolucion as rr")
                                            ->whereNull("rr.deleted_at")
                                            ->where("rr.fecha_recepcion", ">=", date("Y")."-01-01")
                                            ->select("rr.id_sancion",
                                                    DB::RAW("(select count(*) from registro_resolucion where rr.id_sancion=registro_resolucion.id_sancion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=1) as ENERO,
                                                    (select count(*) from registro_resolucion where rr.id_sancion=registro_resolucion.id_sancion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=2) as FEBRERO,
                                                    (select count(*) from registro_resolucion where rr.id_sancion=registro_resolucion.id_sancion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=3) as MARZO,
                                                    (select count(*) from registro_resolucion where rr.id_sancion=registro_resolucion.id_sancion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=4) as ABRIL,
                                                    (select count(*) from registro_resolucion where rr.id_sancion=registro_resolucion.id_sancion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=5) as MAYO,
                                                    (select count(*) from registro_resolucion where rr.id_sancion=registro_resolucion.id_sancion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=6) as JUNIO,
                                                    (select count(*) from registro_resolucion where rr.id_sancion=registro_resolucion.id_sancion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=7) as JULIO,
                                                    (select count(*) from registro_resolucion where rr.id_sancion=registro_resolucion.id_sancion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=8) as AGOSTO,
                                                    (select count(*) from registro_resolucion where rr.id_sancion=registro_resolucion.id_sancion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=9) as SEPTIEMBRE,
                                                    (select count(*) from registro_resolucion where rr.id_sancion=registro_resolucion.id_sancion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=10) as OCTUBRE,
                                                    (select count(*) from registro_resolucion where rr.id_sancion=registro_resolucion.id_sancion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=11) as NOVIEMBRE,
                                                    (select count(*) from registro_resolucion where rr.id_sancion=registro_resolucion.id_sancion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=12) as DICIEMBRE,
                                                    (select count(*) from registro_resolucion where rr.id_sancion=registro_resolucion.id_sancion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y").") as TOTAL"))
                                            ->groupBy("rr.id_sancion")
                                            ->orderBy("rr.id_sancion", "asc")
                                            ->get();                                       
                                            
                                            
        $registro_giro = CatalogoGiro::select("id", "descripcion",
                                            DB::RAW("(select count(*) from registro_resolucion where catalogo_giro.id=registro_resolucion.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=1) as ENERO,
                                            (select count(*) from registro_resolucion where catalogo_giro.id=registro_resolucion.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=2) as FEBRERO,
                                            (select count(*) from registro_resolucion where catalogo_giro.id=registro_resolucion.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=3) as MARZO,
                                            (select count(*) from registro_resolucion where catalogo_giro.id=registro_resolucion.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=4) as ABRIL,
                                            (select count(*) from registro_resolucion where catalogo_giro.id=registro_resolucion.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=5) as MAYO,
                                            (select count(*) from registro_resolucion where catalogo_giro.id=registro_resolucion.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=6) as JUNIO,
                                            (select count(*) from registro_resolucion where catalogo_giro.id=registro_resolucion.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=7) as JULIO,
                                            (select count(*) from registro_resolucion where catalogo_giro.id=registro_resolucion.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=8) as AGOSTO,
                                            (select count(*) from registro_resolucion where catalogo_giro.id=registro_resolucion.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=9) as SEPTIEMBRE,
                                            (select count(*) from registro_resolucion where catalogo_giro.id=registro_resolucion.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=10) as OCTUBRE,
                                            (select count(*) from registro_resolucion where catalogo_giro.id=registro_resolucion.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=11) as NOVIEMBRE,
                                            (select count(*) from registro_resolucion where catalogo_giro.id=registro_resolucion.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=12) as DICIEMBRE,
                                            (select count(*) from registro_resolucion where catalogo_giro.id=registro_resolucion.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y").") as TOTAL"))
                                            ->get();     
                                            
        $registro_trabajador = CatalogoTrabajador::join("rel_trabajador_area_operativa", function ($join) {
                                                $join->on('catalogo_trabajador.id', '=', 'rel_trabajador_area_operativa.id_catalogo_trabajador')
                                                ->where("rel_trabajador_area_operativa.id_tipo", "=", 3);
                                            })                                            
                                            ->select("catalogo_trabajador.nombre as descripcion",
                                            DB::RAW("(select count(*) from registro_resolucion where rel_trabajador_area_operativa.id=registro_resolucion.id_resolutor  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=1) as ENERO,
                                            (select count(*) from registro_resolucion where rel_trabajador_area_operativa.id=registro_resolucion.id_resolutor  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=2) as FEBRERO,
                                            (select count(*) from registro_resolucion where rel_trabajador_area_operativa.id=registro_resolucion.id_resolutor  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=3) as MARZO,
                                            (select count(*) from registro_resolucion where rel_trabajador_area_operativa.id=registro_resolucion.id_resolutor  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=4) as ABRIL,
                                            (select count(*) from registro_resolucion where rel_trabajador_area_operativa.id=registro_resolucion.id_resolutor  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=5) as MAYO,
                                            (select count(*) from registro_resolucion where rel_trabajador_area_operativa.id=registro_resolucion.id_resolutor  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=6) as JUNIO,
                                            (select count(*) from registro_resolucion where rel_trabajador_area_operativa.id=registro_resolucion.id_resolutor  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=7) as JULIO,
                                            (select count(*) from registro_resolucion where rel_trabajador_area_operativa.id=registro_resolucion.id_resolutor  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=8) as AGOSTO,
                                            (select count(*) from registro_resolucion where rel_trabajador_area_operativa.id=registro_resolucion.id_resolutor  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=9) as SEPTIEMBRE,
                                            (select count(*) from registro_resolucion where rel_trabajador_area_operativa.id=registro_resolucion.id_resolutor  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=10) as OCTUBRE,
                                            (select count(*) from registro_resolucion where rel_trabajador_area_operativa.id=registro_resolucion.id_resolutor  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=11) as NOVIEMBRE,
                                            (select count(*) from registro_resolucion where rel_trabajador_area_operativa.id=registro_resolucion.id_resolutor  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=12) as DICIEMBRE,
                                            (select count(*) from registro_resolucion where rel_trabajador_area_operativa.id=registro_resolucion.id_resolutor  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y").") as TOTAL"));    
                                            
        if($parametros['id_area_operativa'] != 0)
        {
            
            $registro_trabajador = $registro_trabajador->where("rel_trabajador_area_operativa.id_catalogo_area_operativa", "=", $parametros['id_area_operativa']);
        }   
        $registro_trabajador = $registro_trabajador->get(); 
        
        $arreglo_respuesta = Array("Area_Operativa"=>$registro_area_operativa, "Estatus"=>$registro_estatus_documento,  "Recurso"=> $registro_recurso, "Sancion"=> $registro_sancion, "Giro"=>$registro_giro, "Trabajador"=> $registro_trabajador, "Titulo_Filtro"=> $titulo_filtro);
        return Response::json([ 'data' => $arreglo_respuesta],200);
                        
    }
}
