<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\CatalogoTipoDocumento, App\Models\CatalogoAreaOperativa, App\Models\CatalogoGiro, App\Models\CatalogoMedidaSeguridad, App\Models\CatalogoTrabajador, App\Models\CatalogoEstatusDocumento;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;

class ReporteSeguimientoDictamenController extends Controller
{
    public function index(Request $request)
    {
        $parametros = $parametros = Input::only('status','q','page','per_page', 'id_area_operativa');

        $filtro = "";
        $titulo_filtro = "TODOS";
        if($parametros['id_area_operativa'] != 0)
        {
            $filtro = " and registro_dictamen.id_area_operativa=".$parametros['id_area_operativa'];
            $tabla_area_operativa = CatalogoAreaOperativa::find($parametros['id_area_operativa']);
            $titulo_filtro = $tabla_area_operativa->descripcion;
        }


        $registro_tipo_acta = CatalogoTipoDocumento::where("id_documento",2)  
                                            ->select("id", "descripcion",
                                            DB::RAW("(select count(*) from registro_dictamen where catalogo_tipo_documento.id=registro_dictamen.id_tipo_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=1) as ENERO,
                                            (select count(*) from registro_dictamen where catalogo_tipo_documento.id=registro_dictamen.id_tipo_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=2) as FEBRERO,
                                            (select count(*) from registro_dictamen where catalogo_tipo_documento.id=registro_dictamen.id_tipo_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=3) as MARZO,
                                            (select count(*) from registro_dictamen where catalogo_tipo_documento.id=registro_dictamen.id_tipo_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=4) as ABRIL,
                                            (select count(*) from registro_dictamen where catalogo_tipo_documento.id=registro_dictamen.id_tipo_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=5) as MAYO,
                                            (select count(*) from registro_dictamen where catalogo_tipo_documento.id=registro_dictamen.id_tipo_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=6) as JUNIO,
                                            (select count(*) from registro_dictamen where catalogo_tipo_documento.id=registro_dictamen.id_tipo_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=7) as JULIO,
                                            (select count(*) from registro_dictamen where catalogo_tipo_documento.id=registro_dictamen.id_tipo_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=8) as AGOSTO,
                                            (select count(*) from registro_dictamen where catalogo_tipo_documento.id=registro_dictamen.id_tipo_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=9) as SEPTIEMBRE,
                                            (select count(*) from registro_dictamen where catalogo_tipo_documento.id=registro_dictamen.id_tipo_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=10) as OCTUBRE,
                                            (select count(*) from registro_dictamen where catalogo_tipo_documento.id=registro_dictamen.id_tipo_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=11) as NOVIEMBRE,
                                            (select count(*) from registro_dictamen where catalogo_tipo_documento.id=registro_dictamen.id_tipo_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=12) as DICIEMBRE,
                                            (select count(*) from registro_dictamen where catalogo_tipo_documento.id=registro_dictamen.id_tipo_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y").") as TOTAL"))
                                            ->get();
       
        $registro_estatus_documento = CatalogoEstatusDocumento::where("id_tipo",2)  
                                            ->select("id", "descripcion",
                                            DB::RAW("(select count(*) from registro_dictamen where catalogo_estatus_documento.id=registro_dictamen.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=1) as ENERO,
                                            (select count(*) from registro_dictamen where catalogo_estatus_documento.id=registro_dictamen.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=2) as FEBRERO,
                                            (select count(*) from registro_dictamen where catalogo_estatus_documento.id=registro_dictamen.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=3) as MARZO,
                                            (select count(*) from registro_dictamen where catalogo_estatus_documento.id=registro_dictamen.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=4) as ABRIL,
                                            (select count(*) from registro_dictamen where catalogo_estatus_documento.id=registro_dictamen.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=5) as MAYO,
                                            (select count(*) from registro_dictamen where catalogo_estatus_documento.id=registro_dictamen.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=6) as JUNIO,
                                            (select count(*) from registro_dictamen where catalogo_estatus_documento.id=registro_dictamen.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=7) as JULIO,
                                            (select count(*) from registro_dictamen where catalogo_estatus_documento.id=registro_dictamen.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=8) as AGOSTO,
                                            (select count(*) from registro_dictamen where catalogo_estatus_documento.id=registro_dictamen.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=9) as SEPTIEMBRE,
                                            (select count(*) from registro_dictamen where catalogo_estatus_documento.id=registro_dictamen.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=10) as OCTUBRE,
                                            (select count(*) from registro_dictamen where catalogo_estatus_documento.id=registro_dictamen.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=11) as NOVIEMBRE,
                                            (select count(*) from registro_dictamen where catalogo_estatus_documento.id=registro_dictamen.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=12) as DICIEMBRE,
                                            (select count(*) from registro_dictamen where catalogo_estatus_documento.id=registro_dictamen.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y").") as TOTAL"))
                                            ->get();
       
        $registro_area_operativa = CatalogoAreaOperativa::select("id", "descripcion",
                                            DB::RAW("(select count(*) from registro_dictamen where catalogo_area_operativa.id=registro_dictamen.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=1) as ENERO,
                                            (select count(*) from registro_dictamen where catalogo_area_operativa.id=registro_dictamen.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=2) as FEBRERO,
                                            (select count(*) from registro_dictamen where catalogo_area_operativa.id=registro_dictamen.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=3) as MARZO,
                                            (select count(*) from registro_dictamen where catalogo_area_operativa.id=registro_dictamen.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=4) as ABRIL,
                                            (select count(*) from registro_dictamen where catalogo_area_operativa.id=registro_dictamen.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=5) as MAYO,
                                            (select count(*) from registro_dictamen where catalogo_area_operativa.id=registro_dictamen.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=6) as JUNIO,
                                            (select count(*) from registro_dictamen where catalogo_area_operativa.id=registro_dictamen.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=7) as JULIO,
                                            (select count(*) from registro_dictamen where catalogo_area_operativa.id=registro_dictamen.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=8) as AGOSTO,
                                            (select count(*) from registro_dictamen where catalogo_area_operativa.id=registro_dictamen.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=9) as SEPTIEMBRE,
                                            (select count(*) from registro_dictamen where catalogo_area_operativa.id=registro_dictamen.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=10) as OCTUBRE,
                                            (select count(*) from registro_dictamen where catalogo_area_operativa.id=registro_dictamen.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=11) as NOVIEMBRE,
                                            (select count(*) from registro_dictamen where catalogo_area_operativa.id=registro_dictamen.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=12) as DICIEMBRE,
                                            (select count(*) from registro_dictamen where catalogo_area_operativa.id=registro_dictamen.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y").") as TOTAL"));
        
        if($parametros['id_area_operativa'] != 0)
        {
            $registro_area_operativa = $registro_area_operativa->where("id", "=", $parametros['id_area_operativa']);
        }                                    

        $registro_area_operativa = $registro_area_operativa->get();

        $registro_resultados = DB::table("registro_dictamen as rd")
                                            ->whereNull("rd.deleted_at")
                                            ->where("rd.fecha_recepcion", ">=", date("Y")."-01-01")
                                            ->select("rd.id_resultado_lesp",
                                                    DB::RAW("(select count(*) from registro_dictamen where rd.id_resultado_lesp=registro_dictamen.id_resultado_lesp and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=1) as ENERO,
                                                    (select count(*) from registro_dictamen where rd.id_resultado_lesp=registro_dictamen.id_resultado_lesp and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=2) as FEBRERO,
                                                    (select count(*) from registro_dictamen where rd.id_resultado_lesp=registro_dictamen.id_resultado_lesp and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=3) as MARZO,
                                                    (select count(*) from registro_dictamen where rd.id_resultado_lesp=registro_dictamen.id_resultado_lesp and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=4) as ABRIL,
                                                    (select count(*) from registro_dictamen where rd.id_resultado_lesp=registro_dictamen.id_resultado_lesp and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=5) as MAYO,
                                                    (select count(*) from registro_dictamen where rd.id_resultado_lesp=registro_dictamen.id_resultado_lesp and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=6) as JUNIO,
                                                    (select count(*) from registro_dictamen where rd.id_resultado_lesp=registro_dictamen.id_resultado_lesp and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=7) as JULIO,
                                                    (select count(*) from registro_dictamen where rd.id_resultado_lesp=registro_dictamen.id_resultado_lesp and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=8) as AGOSTO,
                                                    (select count(*) from registro_dictamen where rd.id_resultado_lesp=registro_dictamen.id_resultado_lesp and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=9) as SEPTIEMBRE,
                                                    (select count(*) from registro_dictamen where rd.id_resultado_lesp=registro_dictamen.id_resultado_lesp and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=10) as OCTUBRE,
                                                    (select count(*) from registro_dictamen where rd.id_resultado_lesp=registro_dictamen.id_resultado_lesp and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=11) as NOVIEMBRE,
                                                    (select count(*) from registro_dictamen where rd.id_resultado_lesp=registro_dictamen.id_resultado_lesp and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=12) as DICIEMBRE,
                                                    (select count(*) from registro_dictamen where rd.id_resultado_lesp=registro_dictamen.id_resultado_lesp and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y").") as TOTAL"))
                                            ->groupBy("rd.id_resultado_lesp")
                                            ->orderBy("rd.id_resultado_lesp", "asc")
                                            ->get();   

        $registro_anomalias = DB::table("registro_dictamen as rd")
                                            ->whereNull("rd.deleted_at")
                                            ->where("rd.fecha_recepcion", ">=", date("Y")."-01-01")
                                            ->select("rd.id_anomalias",
                                                    DB::RAW("(select count(*) from registro_dictamen where rd.id_anomalias=registro_dictamen.id_anomalias and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=1) as ENERO,
                                                    (select count(*) from registro_dictamen where rd.id_anomalias=registro_dictamen.id_anomalias and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=2) as FEBRERO,
                                                    (select count(*) from registro_dictamen where rd.id_anomalias=registro_dictamen.id_anomalias and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=3) as MARZO,
                                                    (select count(*) from registro_dictamen where rd.id_anomalias=registro_dictamen.id_anomalias and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=4) as ABRIL,
                                                    (select count(*) from registro_dictamen where rd.id_anomalias=registro_dictamen.id_anomalias and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=5) as MAYO,
                                                    (select count(*) from registro_dictamen where rd.id_anomalias=registro_dictamen.id_anomalias and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=6) as JUNIO,
                                                    (select count(*) from registro_dictamen where rd.id_anomalias=registro_dictamen.id_anomalias and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=7) as JULIO,
                                                    (select count(*) from registro_dictamen where rd.id_anomalias=registro_dictamen.id_anomalias and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=8) as AGOSTO,
                                                    (select count(*) from registro_dictamen where rd.id_anomalias=registro_dictamen.id_anomalias and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=9) as SEPTIEMBRE,
                                                    (select count(*) from registro_dictamen where rd.id_anomalias=registro_dictamen.id_anomalias and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=10) as OCTUBRE,
                                                    (select count(*) from registro_dictamen where rd.id_anomalias=registro_dictamen.id_anomalias and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=11) as NOVIEMBRE,
                                                    (select count(*) from registro_dictamen where rd.id_anomalias=registro_dictamen.id_anomalias and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=12) as DICIEMBRE,
                                                    (select count(*) from registro_dictamen where rd.id_anomalias=registro_dictamen.id_anomalias and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y").") as TOTAL"))
                                            ->groupBy("rd.id_anomalias")
                                            ->orderBy("rd.id_anomalias", "asc")
                                            ->get();                                       
                                            
        $registro_medida_seguridad = CatalogoMedidaSeguridad::select("id", "descripcion",
                                            DB::RAW("(select count(*) from registro_dictamen where catalogo_medida_seguridad.id=registro_dictamen.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=1) as ENERO,
                                            (select count(*) from registro_dictamen where catalogo_medida_seguridad.id=registro_dictamen.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=2) as FEBRERO,
                                            (select count(*) from registro_dictamen where catalogo_medida_seguridad.id=registro_dictamen.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=3) as MARZO,
                                            (select count(*) from registro_dictamen where catalogo_medida_seguridad.id=registro_dictamen.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=4) as ABRIL,
                                            (select count(*) from registro_dictamen where catalogo_medida_seguridad.id=registro_dictamen.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=5) as MAYO,
                                            (select count(*) from registro_dictamen where catalogo_medida_seguridad.id=registro_dictamen.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=6) as JUNIO,
                                            (select count(*) from registro_dictamen where catalogo_medida_seguridad.id=registro_dictamen.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=7) as JULIO,
                                            (select count(*) from registro_dictamen where catalogo_medida_seguridad.id=registro_dictamen.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=8) as AGOSTO,
                                            (select count(*) from registro_dictamen where catalogo_medida_seguridad.id=registro_dictamen.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=9) as SEPTIEMBRE,
                                            (select count(*) from registro_dictamen where catalogo_medida_seguridad.id=registro_dictamen.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=10) as OCTUBRE,
                                            (select count(*) from registro_dictamen where catalogo_medida_seguridad.id=registro_dictamen.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=11) as NOVIEMBRE,
                                            (select count(*) from registro_dictamen where catalogo_medida_seguridad.id=registro_dictamen.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=12) as DICIEMBRE,
                                            (select count(*) from registro_dictamen where catalogo_medida_seguridad.id=registro_dictamen.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y").") as TOTAL"))
                                            ->get(); 
                                            
        $registro_giro = CatalogoGiro::select("id", "descripcion",
                                            DB::RAW("(select count(*) from registro_dictamen where catalogo_giro.id=registro_dictamen.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=1) as ENERO,
                                            (select count(*) from registro_dictamen where catalogo_giro.id=registro_dictamen.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=2) as FEBRERO,
                                            (select count(*) from registro_dictamen where catalogo_giro.id=registro_dictamen.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=3) as MARZO,
                                            (select count(*) from registro_dictamen where catalogo_giro.id=registro_dictamen.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=4) as ABRIL,
                                            (select count(*) from registro_dictamen where catalogo_giro.id=registro_dictamen.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=5) as MAYO,
                                            (select count(*) from registro_dictamen where catalogo_giro.id=registro_dictamen.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=6) as JUNIO,
                                            (select count(*) from registro_dictamen where catalogo_giro.id=registro_dictamen.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=7) as JULIO,
                                            (select count(*) from registro_dictamen where catalogo_giro.id=registro_dictamen.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=8) as AGOSTO,
                                            (select count(*) from registro_dictamen where catalogo_giro.id=registro_dictamen.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=9) as SEPTIEMBRE,
                                            (select count(*) from registro_dictamen where catalogo_giro.id=registro_dictamen.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=10) as OCTUBRE,
                                            (select count(*) from registro_dictamen where catalogo_giro.id=registro_dictamen.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=11) as NOVIEMBRE,
                                            (select count(*) from registro_dictamen where catalogo_giro.id=registro_dictamen.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=12) as DICIEMBRE,
                                            (select count(*) from registro_dictamen where catalogo_giro.id=registro_dictamen.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y").") as TOTAL"))
                                            ->get();     
                                            
        $registro_trabajador = CatalogoTrabajador::join("rel_trabajador_area_operativa", function ($join) {
                                                $join->on('catalogo_trabajador.id', '=', 'rel_trabajador_area_operativa.id_catalogo_trabajador')
                                                ->where("rel_trabajador_area_operativa.id_tipo", "=", 2);
                                            })                                            
                                            ->select("catalogo_trabajador.nombre as descripcion",
                                            DB::RAW("(select count(*) from registro_dictamen where rel_trabajador_area_operativa.id=registro_dictamen.id_dictaminador  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=1) as ENERO,
                                            (select count(*) from registro_dictamen where rel_trabajador_area_operativa.id=registro_dictamen.id_dictaminador  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=2) as FEBRERO,
                                            (select count(*) from registro_dictamen where rel_trabajador_area_operativa.id=registro_dictamen.id_dictaminador  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=3) as MARZO,
                                            (select count(*) from registro_dictamen where rel_trabajador_area_operativa.id=registro_dictamen.id_dictaminador  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=4) as ABRIL,
                                            (select count(*) from registro_dictamen where rel_trabajador_area_operativa.id=registro_dictamen.id_dictaminador  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=5) as MAYO,
                                            (select count(*) from registro_dictamen where rel_trabajador_area_operativa.id=registro_dictamen.id_dictaminador  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=6) as JUNIO,
                                            (select count(*) from registro_dictamen where rel_trabajador_area_operativa.id=registro_dictamen.id_dictaminador  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=7) as JULIO,
                                            (select count(*) from registro_dictamen where rel_trabajador_area_operativa.id=registro_dictamen.id_dictaminador  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=8) as AGOSTO,
                                            (select count(*) from registro_dictamen where rel_trabajador_area_operativa.id=registro_dictamen.id_dictaminador  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=9) as SEPTIEMBRE,
                                            (select count(*) from registro_dictamen where rel_trabajador_area_operativa.id=registro_dictamen.id_dictaminador  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=10) as OCTUBRE,
                                            (select count(*) from registro_dictamen where rel_trabajador_area_operativa.id=registro_dictamen.id_dictaminador  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=11) as NOVIEMBRE,
                                            (select count(*) from registro_dictamen where rel_trabajador_area_operativa.id=registro_dictamen.id_dictaminador  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=12) as DICIEMBRE,
                                            (select count(*) from registro_dictamen where rel_trabajador_area_operativa.id=registro_dictamen.id_dictaminador  and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y").") as TOTAL"));    
                                            
        if($parametros['id_area_operativa'] != 0)
        {
            
            $registro_trabajador = $registro_trabajador->where("rel_trabajador_area_operativa.id_catalogo_area_operativa", "=", $parametros['id_area_operativa']);
        }   
        $registro_trabajador = $registro_trabajador->get(); 
        
        $arreglo_respuesta = Array("Tipo_Acta"=>$registro_tipo_acta, "Area_Operativa"=>$registro_area_operativa, "Estatus"=>$registro_estatus_documento,  "Resultados_Lesp"=> $registro_resultados, "Anomalias"=> $registro_anomalias, "Medida_Seguridad"=>$registro_medida_seguridad, "Giro"=>$registro_giro, "Trabajador"=> $registro_trabajador, "Titulo_Filtro"=> $titulo_filtro);
        return Response::json([ 'data' => $arreglo_respuesta],200);
                        
    }
}
