<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\CatalogoGiro, App\Models\CatalogoEstatusDocumento;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;

class ReporteSeguimientoLicenciaController extends Controller
{
    public function index(Request $request)
    {
        $parametros = $parametros = Input::only('status','q','page','per_page', 'id_area_operativa');

        $filtro = "";
        $titulo_filtro = "TODOS";
        if($parametros['id_area_operativa'] != 0)
        {
            //$filtro = " and registro_licencia.id_area_operativa=".$parametros['id_area_operativa'];
            //$tabla_area_operativa = CatalogoAreaOperativa::find($parametros['id_area_operativa']);
            //$titulo_filtro = $tabla_area_operativa->descripcion;
        }


        
        $registro_estatus_documento = CatalogoEstatusDocumento::where("id_tipo",4)  
                                            ->select("id", "descripcion",
                                            DB::RAW("(select count(*) from registro_licencia where catalogo_estatus_documento.id=registro_licencia.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=1) as ENERO,
                                            (select count(*) from registro_licencia where catalogo_estatus_documento.id=registro_licencia.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=2) as FEBRERO,
                                            (select count(*) from registro_licencia where catalogo_estatus_documento.id=registro_licencia.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=3) as MARZO,
                                            (select count(*) from registro_licencia where catalogo_estatus_documento.id=registro_licencia.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=4) as ABRIL,
                                            (select count(*) from registro_licencia where catalogo_estatus_documento.id=registro_licencia.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=5) as MAYO,
                                            (select count(*) from registro_licencia where catalogo_estatus_documento.id=registro_licencia.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=6) as JUNIO,
                                            (select count(*) from registro_licencia where catalogo_estatus_documento.id=registro_licencia.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=7) as JULIO,
                                            (select count(*) from registro_licencia where catalogo_estatus_documento.id=registro_licencia.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=8) as AGOSTO,
                                            (select count(*) from registro_licencia where catalogo_estatus_documento.id=registro_licencia.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=9) as SEPTIEMBRE,
                                            (select count(*) from registro_licencia where catalogo_estatus_documento.id=registro_licencia.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=10) as OCTUBRE,
                                            (select count(*) from registro_licencia where catalogo_estatus_documento.id=registro_licencia.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=11) as NOVIEMBRE,
                                            (select count(*) from registro_licencia where catalogo_estatus_documento.id=registro_licencia.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=12) as DICIEMBRE,
                                            (select count(*) from registro_licencia where catalogo_estatus_documento.id=registro_licencia.id_estatus and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y").") as TOTAL"))
                                            ->get();
       
        $registro_verificacion = DB::table("registro_licencia as rr")
                                            ->whereNull("rr.deleted_at")
                                            ->where("rr.fecha_recepcion", ">=", date("Y")."-01-01")
                                            ->select("rr.id_verificacion_sanitaria",
                                                    DB::RAW("(select count(*) from registro_licencia where rr.id_verificacion_sanitaria=registro_licencia.id_verificacion_sanitaria and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=1) as ENERO,
                                                    (select count(*) from registro_licencia where rr.id_verificacion_sanitaria=registro_licencia.id_verificacion_sanitaria and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=2) as FEBRERO,
                                                    (select count(*) from registro_licencia where rr.id_verificacion_sanitaria=registro_licencia.id_verificacion_sanitaria and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=3) as MARZO,
                                                    (select count(*) from registro_licencia where rr.id_verificacion_sanitaria=registro_licencia.id_verificacion_sanitaria and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=4) as ABRIL,
                                                    (select count(*) from registro_licencia where rr.id_verificacion_sanitaria=registro_licencia.id_verificacion_sanitaria and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=5) as MAYO,
                                                    (select count(*) from registro_licencia where rr.id_verificacion_sanitaria=registro_licencia.id_verificacion_sanitaria and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=6) as JUNIO,
                                                    (select count(*) from registro_licencia where rr.id_verificacion_sanitaria=registro_licencia.id_verificacion_sanitaria and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=7) as JULIO,
                                                    (select count(*) from registro_licencia where rr.id_verificacion_sanitaria=registro_licencia.id_verificacion_sanitaria and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=8) as AGOSTO,
                                                    (select count(*) from registro_licencia where rr.id_verificacion_sanitaria=registro_licencia.id_verificacion_sanitaria and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=9) as SEPTIEMBRE,
                                                    (select count(*) from registro_licencia where rr.id_verificacion_sanitaria=registro_licencia.id_verificacion_sanitaria and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=10) as OCTUBRE,
                                                    (select count(*) from registro_licencia where rr.id_verificacion_sanitaria=registro_licencia.id_verificacion_sanitaria and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=11) as NOVIEMBRE,
                                                    (select count(*) from registro_licencia where rr.id_verificacion_sanitaria=registro_licencia.id_verificacion_sanitaria and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=12) as DICIEMBRE,
                                                    (select count(*) from registro_licencia where rr.id_verificacion_sanitaria=registro_licencia.id_verificacion_sanitaria and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y").") as TOTAL"))
                                            ->groupBy("rr.id_verificacion_sanitaria")
                                            ->orderBy("rr.id_verificacion_sanitaria", "asc")
                                            ->get();   

        $registro_dictamen = DB::table("registro_licencia as rr")
                                            ->whereNull("rr.deleted_at")
                                            ->where("rr.fecha_recepcion", ">=", date("Y")."-01-01")
                                            ->select("rr.id_dictamen",
                                                    DB::RAW("(select count(*) from registro_licencia where rr.id_dictamen=registro_licencia.id_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=1) as ENERO,
                                                    (select count(*) from registro_licencia where rr.id_dictamen=registro_licencia.id_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=2) as FEBRERO,
                                                    (select count(*) from registro_licencia where rr.id_dictamen=registro_licencia.id_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=3) as MARZO,
                                                    (select count(*) from registro_licencia where rr.id_dictamen=registro_licencia.id_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=4) as ABRIL,
                                                    (select count(*) from registro_licencia where rr.id_dictamen=registro_licencia.id_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=5) as MAYO,
                                                    (select count(*) from registro_licencia where rr.id_dictamen=registro_licencia.id_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=6) as JUNIO,
                                                    (select count(*) from registro_licencia where rr.id_dictamen=registro_licencia.id_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=7) as JULIO,
                                                    (select count(*) from registro_licencia where rr.id_dictamen=registro_licencia.id_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=8) as AGOSTO,
                                                    (select count(*) from registro_licencia where rr.id_dictamen=registro_licencia.id_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=9) as SEPTIEMBRE,
                                                    (select count(*) from registro_licencia where rr.id_dictamen=registro_licencia.id_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=10) as OCTUBRE,
                                                    (select count(*) from registro_licencia where rr.id_dictamen=registro_licencia.id_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=11) as NOVIEMBRE,
                                                    (select count(*) from registro_licencia where rr.id_dictamen=registro_licencia.id_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=12) as DICIEMBRE,
                                                    (select count(*) from registro_licencia where rr.id_dictamen=registro_licencia.id_dictamen and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y").") as TOTAL"))
                                            ->groupBy("rr.id_dictamen")
                                            ->orderBy("rr.id_dictamen", "asc")
                                            ->get();       
                                            
        $registro_notificacion = DB::table("registro_licencia as rr")
                                            ->whereNull("rr.deleted_at")
                                            ->where("rr.fecha_recepcion", ">=", date("Y")."-01-01")
                                            ->select("rr.id_notificacion",
                                                    DB::RAW("(select count(*) from registro_licencia where rr.id_notificacion=registro_licencia.id_notificacion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=1) as ENERO,
                                                    (select count(*) from registro_licencia where rr.id_notificacion=registro_licencia.id_notificacion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=2) as FEBRERO,
                                                    (select count(*) from registro_licencia where rr.id_notificacion=registro_licencia.id_notificacion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=3) as MARZO,
                                                    (select count(*) from registro_licencia where rr.id_notificacion=registro_licencia.id_notificacion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=4) as ABRIL,
                                                    (select count(*) from registro_licencia where rr.id_notificacion=registro_licencia.id_notificacion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=5) as MAYO,
                                                    (select count(*) from registro_licencia where rr.id_notificacion=registro_licencia.id_notificacion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=6) as JUNIO,
                                                    (select count(*) from registro_licencia where rr.id_notificacion=registro_licencia.id_notificacion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=7) as JULIO,
                                                    (select count(*) from registro_licencia where rr.id_notificacion=registro_licencia.id_notificacion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=8) as AGOSTO,
                                                    (select count(*) from registro_licencia where rr.id_notificacion=registro_licencia.id_notificacion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=9) as SEPTIEMBRE,
                                                    (select count(*) from registro_licencia where rr.id_notificacion=registro_licencia.id_notificacion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=10) as OCTUBRE,
                                                    (select count(*) from registro_licencia where rr.id_notificacion=registro_licencia.id_notificacion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=11) as NOVIEMBRE,
                                                    (select count(*) from registro_licencia where rr.id_notificacion=registro_licencia.id_notificacion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=12) as DICIEMBRE,
                                                    (select count(*) from registro_licencia where rr.id_notificacion=registro_licencia.id_notificacion and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y").") as TOTAL"))
                                            ->groupBy("rr.id_notificacion")
                                            ->orderBy("rr.id_notificacion", "asc")
                                            ->get();            
                                            
        $registro_entrega = DB::table("registro_licencia as rr")
                                            ->whereNull("rr.deleted_at")
                                            ->where("rr.fecha_recepcion", ">=", date("Y")."-01-01")
                                            ->select(
                                                    DB::RAW("(select count(*) from registro_licencia where rr.fecha_entrega is not null and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=1) as ENERO,
                                                    (select count(*) from registro_licencia where rr.fecha_entrega is not null and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=2) as FEBRERO,
                                                    (select count(*) from registro_licencia where rr.fecha_entrega is not null and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=3) as MARZO,
                                                    (select count(*) from registro_licencia where rr.fecha_entrega is not null and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=4) as ABRIL,
                                                    (select count(*) from registro_licencia where rr.fecha_entrega is not null and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=5) as MAYO,
                                                    (select count(*) from registro_licencia where rr.fecha_entrega is not null and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=6) as JUNIO,
                                                    (select count(*) from registro_licencia where rr.fecha_entrega is not null and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=7) as JULIO,
                                                    (select count(*) from registro_licencia where rr.fecha_entrega is not null and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=8) as AGOSTO,
                                                    (select count(*) from registro_licencia where rr.fecha_entrega is not null and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=9) as SEPTIEMBRE,
                                                    (select count(*) from registro_licencia where rr.fecha_entrega is not null and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=10) as OCTUBRE,
                                                    (select count(*) from registro_licencia where rr.fecha_entrega is not null and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=11) as NOVIEMBRE,
                                                    (select count(*) from registro_licencia where rr.fecha_entrega is not null and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=12) as DICIEMBRE,
                                                    (select count(*) from registro_licencia where rr.fecha_entrega is not null and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y").") as TOTAL"))
                                            ->get();    
                                            
        $registro_solicitudes = DB::table("registro_licencia as rr")
                                            ->whereNull("rr.deleted_at")
                                            ->where("rr.fecha_recepcion", ">=", date("Y")."-01-01")
                                            ->select(
                                                    DB::RAW("(select count(*) from registro_licencia where deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=1) as ENERO,
                                                    (select count(*) from registro_licencia where deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=2) as FEBRERO,
                                                    (select count(*) from registro_licencia where deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=3) as MARZO,
                                                    (select count(*) from registro_licencia where deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=4) as ABRIL,
                                                    (select count(*) from registro_licencia where deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=5) as MAYO,
                                                    (select count(*) from registro_licencia where deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=6) as JUNIO,
                                                    (select count(*) from registro_licencia where deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=7) as JULIO,
                                                    (select count(*) from registro_licencia where deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=8) as AGOSTO,
                                                    (select count(*) from registro_licencia where deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=9) as SEPTIEMBRE,
                                                    (select count(*) from registro_licencia where deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=10) as OCTUBRE,
                                                    (select count(*) from registro_licencia where deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=11) as NOVIEMBRE,
                                                    (select count(*) from registro_licencia where deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=12) as DICIEMBRE,
                                                    (select count(*) from registro_licencia where deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y").") as TOTAL"))
                                            ->get();    
                                            
                                            
        $registro_giro = CatalogoGiro::select("id", "descripcion",
                                            DB::RAW("(select count(*) from registro_licencia where catalogo_giro.id=registro_licencia.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=1) as ENERO,
                                            (select count(*) from registro_licencia where catalogo_giro.id=registro_licencia.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=2) as FEBRERO,
                                            (select count(*) from registro_licencia where catalogo_giro.id=registro_licencia.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=3) as MARZO,
                                            (select count(*) from registro_licencia where catalogo_giro.id=registro_licencia.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=4) as ABRIL,
                                            (select count(*) from registro_licencia where catalogo_giro.id=registro_licencia.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=5) as MAYO,
                                            (select count(*) from registro_licencia where catalogo_giro.id=registro_licencia.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=6) as JUNIO,
                                            (select count(*) from registro_licencia where catalogo_giro.id=registro_licencia.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=7) as JULIO,
                                            (select count(*) from registro_licencia where catalogo_giro.id=registro_licencia.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=8) as AGOSTO,
                                            (select count(*) from registro_licencia where catalogo_giro.id=registro_licencia.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=9) as SEPTIEMBRE,
                                            (select count(*) from registro_licencia where catalogo_giro.id=registro_licencia.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=10) as OCTUBRE,
                                            (select count(*) from registro_licencia where catalogo_giro.id=registro_licencia.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=11) as NOVIEMBRE,
                                            (select count(*) from registro_licencia where catalogo_giro.id=registro_licencia.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y")." and MONTH(fecha_recepcion)=12) as DICIEMBRE,
                                            (select count(*) from registro_licencia where catalogo_giro.id=registro_licencia.id_giro and deleted_at is null $filtro and YEAR(fecha_recepcion)=".date("Y").") as TOTAL"))
                                            ->get();     
                                            
        
        
        $arreglo_respuesta = Array( "Estatus"=>$registro_estatus_documento, "Registro_Verificacion"=> $registro_verificacion, "Registro_Dictamen"=> $registro_dictamen, "Registro_Notificacion"=>$registro_notificacion, "Registro_Entrega"=>$registro_entrega, "Registro_Solicitud"=>$registro_solicitudes, "Giro"=>$registro_giro, "Titulo_Filtro"=> $titulo_filtro);
        return Response::json([ 'data' => $arreglo_respuesta],200);
                        
    }
}
