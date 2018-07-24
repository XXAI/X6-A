<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\CatalogoTipoDocumento, App\Models\CatalogoAreaOperativa, App\Models\CatalogoGiro, App\Models\CatalogoMedidaSeguridad, App\Models\CatalogoTrabajador;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;

class ReporteSeguimientoVerificacionController extends Controller
{
    public function index(Request $request)
    {
        $parametros = $parametros = Input::only('status','q','page','per_page', 'id_area_operativa');

        $filtro = "";
        $titulo_filtro = "TODOS";
        if($parametros['id_area_operativa'] != 0)
        {
            $filtro = " and registro_verificacion.id_area_operativa=".$parametros['id_area_operativa'];
            $tabla_area_operativa = CatalogoAreaOperativa::find($parametros['id_area_operativa']);
            $titulo_filtro = $tabla_area_operativa->descripcion;
        }


        $registro_tipo_acta = CatalogoTipoDocumento::where("id_documento",1)  
                                            ->select("id", "descripcion",
                                            DB::RAW("(select count(*) from registro_verificacion where catalogo_tipo_documento.id=registro_verificacion.id_tipo_acta and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=1) as ENERO,
                                            (select count(*) from registro_verificacion where catalogo_tipo_documento.id=registro_verificacion.id_tipo_acta and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=2) as FEBRERO,
                                            (select count(*) from registro_verificacion where catalogo_tipo_documento.id=registro_verificacion.id_tipo_acta and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=3) as MARZO,
                                            (select count(*) from registro_verificacion where catalogo_tipo_documento.id=registro_verificacion.id_tipo_acta and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=4) as ABRIL,
                                            (select count(*) from registro_verificacion where catalogo_tipo_documento.id=registro_verificacion.id_tipo_acta and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=5) as MAYO,
                                            (select count(*) from registro_verificacion where catalogo_tipo_documento.id=registro_verificacion.id_tipo_acta and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=6) as JUNIO,
                                            (select count(*) from registro_verificacion where catalogo_tipo_documento.id=registro_verificacion.id_tipo_acta and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=7) as JULIO,
                                            (select count(*) from registro_verificacion where catalogo_tipo_documento.id=registro_verificacion.id_tipo_acta and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=8) as AGOSTO,
                                            (select count(*) from registro_verificacion where catalogo_tipo_documento.id=registro_verificacion.id_tipo_acta and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=9) as SEPTIEMBRE,
                                            (select count(*) from registro_verificacion where catalogo_tipo_documento.id=registro_verificacion.id_tipo_acta and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=10) as OCTUBRE,
                                            (select count(*) from registro_verificacion where catalogo_tipo_documento.id=registro_verificacion.id_tipo_acta and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=11) as NOVIEMBRE,
                                            (select count(*) from registro_verificacion where catalogo_tipo_documento.id=registro_verificacion.id_tipo_acta and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=12) as DICIEMBRE,
                                            (select count(*) from registro_verificacion where catalogo_tipo_documento.id=registro_verificacion.id_tipo_acta and deleted_at is null $filtro and YEAR(fecha_orden)=2018) as TOTAL"))
                                            ->get();
       
        $registro_area_operativa = CatalogoAreaOperativa::select("id", "descripcion",
                                            DB::RAW("(select count(*) from registro_verificacion where catalogo_area_operativa.id=registro_verificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=1) as ENERO,
                                            (select count(*) from registro_verificacion where catalogo_area_operativa.id=registro_verificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=2) as FEBRERO,
                                            (select count(*) from registro_verificacion where catalogo_area_operativa.id=registro_verificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=3) as MARZO,
                                            (select count(*) from registro_verificacion where catalogo_area_operativa.id=registro_verificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=4) as ABRIL,
                                            (select count(*) from registro_verificacion where catalogo_area_operativa.id=registro_verificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=5) as MAYO,
                                            (select count(*) from registro_verificacion where catalogo_area_operativa.id=registro_verificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=6) as JUNIO,
                                            (select count(*) from registro_verificacion where catalogo_area_operativa.id=registro_verificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=7) as JULIO,
                                            (select count(*) from registro_verificacion where catalogo_area_operativa.id=registro_verificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=8) as AGOSTO,
                                            (select count(*) from registro_verificacion where catalogo_area_operativa.id=registro_verificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=9) as SEPTIEMBRE,
                                            (select count(*) from registro_verificacion where catalogo_area_operativa.id=registro_verificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=10) as OCTUBRE,
                                            (select count(*) from registro_verificacion where catalogo_area_operativa.id=registro_verificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=11) as NOVIEMBRE,
                                            (select count(*) from registro_verificacion where catalogo_area_operativa.id=registro_verificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=12) as DICIEMBRE,
                                            (select count(*) from registro_verificacion where catalogo_area_operativa.id=registro_verificacion.id_area_operativa and deleted_at is null $filtro and YEAR(fecha_orden)=2018) as TOTAL"));
        
        if($parametros['id_area_operativa'] != 0)
        {
            $registro_area_operativa = $registro_area_operativa->where("id", "=", $parametros['id_area_operativa']);
        }                                    

        $registro_area_operativa = $registro_area_operativa->get();

        $registro_motivo_verificacion = DB::table("registro_verificacion as rv")
                                            ->whereNull("rv.deleted_at")
                                            ->where("rv.fecha_orden", ">=", date("Y")."-01-01")
                                            ->select("rv.id_motivo_orden_verificacion",
                                                    DB::RAW("(select count(*) from registro_verificacion where rv.id_motivo_orden_verificacion=registro_verificacion.id_motivo_orden_verificacion and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=1) as ENERO,
                                                    (select count(*) from registro_verificacion where rv.id_motivo_orden_verificacion=registro_verificacion.id_motivo_orden_verificacion and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=2) as FEBRERO,
                                                    (select count(*) from registro_verificacion where rv.id_motivo_orden_verificacion=registro_verificacion.id_motivo_orden_verificacion and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=3) as MARZO,
                                                    (select count(*) from registro_verificacion where rv.id_motivo_orden_verificacion=registro_verificacion.id_motivo_orden_verificacion and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=4) as ABRIL,
                                                    (select count(*) from registro_verificacion where rv.id_motivo_orden_verificacion=registro_verificacion.id_motivo_orden_verificacion and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=5) as MAYO,
                                                    (select count(*) from registro_verificacion where rv.id_motivo_orden_verificacion=registro_verificacion.id_motivo_orden_verificacion and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=6) as JUNIO,
                                                    (select count(*) from registro_verificacion where rv.id_motivo_orden_verificacion=registro_verificacion.id_motivo_orden_verificacion and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=7) as JULIO,
                                                    (select count(*) from registro_verificacion where rv.id_motivo_orden_verificacion=registro_verificacion.id_motivo_orden_verificacion and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=8) as AGOSTO,
                                                    (select count(*) from registro_verificacion where rv.id_motivo_orden_verificacion=registro_verificacion.id_motivo_orden_verificacion and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=9) as SEPTIEMBRE,
                                                    (select count(*) from registro_verificacion where rv.id_motivo_orden_verificacion=registro_verificacion.id_motivo_orden_verificacion and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=10) as OCTUBRE,
                                                    (select count(*) from registro_verificacion where rv.id_motivo_orden_verificacion=registro_verificacion.id_motivo_orden_verificacion and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=11) as NOVIEMBRE,
                                                    (select count(*) from registro_verificacion where rv.id_motivo_orden_verificacion=registro_verificacion.id_motivo_orden_verificacion and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=12) as DICIEMBRE,
                                                    (select count(*) from registro_verificacion where rv.id_motivo_orden_verificacion=registro_verificacion.id_motivo_orden_verificacion and deleted_at is null $filtro and YEAR(fecha_orden)=2018) as TOTAL"))
                                            ->groupBy("rv.id_motivo_orden_verificacion")
                                            ->orderBy("rv.id_motivo_orden_verificacion", "asc")
                                            ->get();   
                                            
        $registro_medida_seguridad = CatalogoMedidaSeguridad::select("id", "descripcion",
                                            DB::RAW("(select count(*) from registro_verificacion where catalogo_medida_seguridad.id=registro_verificacion.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=1) as ENERO,
                                            (select count(*) from registro_verificacion where catalogo_medida_seguridad.id=registro_verificacion.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=2) as FEBRERO,
                                            (select count(*) from registro_verificacion where catalogo_medida_seguridad.id=registro_verificacion.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=3) as MARZO,
                                            (select count(*) from registro_verificacion where catalogo_medida_seguridad.id=registro_verificacion.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=4) as ABRIL,
                                            (select count(*) from registro_verificacion where catalogo_medida_seguridad.id=registro_verificacion.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=5) as MAYO,
                                            (select count(*) from registro_verificacion where catalogo_medida_seguridad.id=registro_verificacion.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=6) as JUNIO,
                                            (select count(*) from registro_verificacion where catalogo_medida_seguridad.id=registro_verificacion.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=7) as JULIO,
                                            (select count(*) from registro_verificacion where catalogo_medida_seguridad.id=registro_verificacion.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=8) as AGOSTO,
                                            (select count(*) from registro_verificacion where catalogo_medida_seguridad.id=registro_verificacion.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=9) as SEPTIEMBRE,
                                            (select count(*) from registro_verificacion where catalogo_medida_seguridad.id=registro_verificacion.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=10) as OCTUBRE,
                                            (select count(*) from registro_verificacion where catalogo_medida_seguridad.id=registro_verificacion.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=11) as NOVIEMBRE,
                                            (select count(*) from registro_verificacion where catalogo_medida_seguridad.id=registro_verificacion.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=12) as DICIEMBRE,
                                            (select count(*) from registro_verificacion where catalogo_medida_seguridad.id=registro_verificacion.id_medida_seguridad and deleted_at is null $filtro and YEAR(fecha_orden)=2018) as TOTAL"))
                                            ->get(); 
                                            
        $registro_giro = CatalogoGiro::select("id", "descripcion",
                                            DB::RAW("(select count(*) from registro_verificacion where catalogo_giro.id=registro_verificacion.id_giro and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=1) as ENERO,
                                            (select count(*) from registro_verificacion where catalogo_giro.id=registro_verificacion.id_giro and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=2) as FEBRERO,
                                            (select count(*) from registro_verificacion where catalogo_giro.id=registro_verificacion.id_giro and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=3) as MARZO,
                                            (select count(*) from registro_verificacion where catalogo_giro.id=registro_verificacion.id_giro and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=4) as ABRIL,
                                            (select count(*) from registro_verificacion where catalogo_giro.id=registro_verificacion.id_giro and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=5) as MAYO,
                                            (select count(*) from registro_verificacion where catalogo_giro.id=registro_verificacion.id_giro and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=6) as JUNIO,
                                            (select count(*) from registro_verificacion where catalogo_giro.id=registro_verificacion.id_giro and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=7) as JULIO,
                                            (select count(*) from registro_verificacion where catalogo_giro.id=registro_verificacion.id_giro and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=8) as AGOSTO,
                                            (select count(*) from registro_verificacion where catalogo_giro.id=registro_verificacion.id_giro and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=9) as SEPTIEMBRE,
                                            (select count(*) from registro_verificacion where catalogo_giro.id=registro_verificacion.id_giro and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=10) as OCTUBRE,
                                            (select count(*) from registro_verificacion where catalogo_giro.id=registro_verificacion.id_giro and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=11) as NOVIEMBRE,
                                            (select count(*) from registro_verificacion where catalogo_giro.id=registro_verificacion.id_giro and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=12) as DICIEMBRE,
                                            (select count(*) from registro_verificacion where catalogo_giro.id=registro_verificacion.id_giro and deleted_at is null $filtro and YEAR(fecha_orden)=2018) as TOTAL"))
                                            ->get();     
                                            
        $registro_trabajador = CatalogoTrabajador::join("rel_trabajador_area_operativa", function ($join) {
                                                $join->on('catalogo_trabajador.id', '=', 'rel_trabajador_area_operativa.id_catalogo_trabajador')
                                                ->where("rel_trabajador_area_operativa.id_tipo", "=", 1);
                                            })                                            
                                            ->select("catalogo_trabajador.nombre as descripcion",
                                            DB::RAW("(select count(*) from registro_verificacion where (rel_trabajador_area_operativa.id=registro_verificacion.id_primer_verificador || rel_trabajador_area_operativa.id=registro_verificacion.id_segundo_verificador)  and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=1) as ENERO,
                                            (select count(*) from registro_verificacion where (rel_trabajador_area_operativa.id=registro_verificacion.id_primer_verificador || rel_trabajador_area_operativa.id=registro_verificacion.id_segundo_verificador)  and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=2) as FEBRERO,
                                            (select count(*) from registro_verificacion where (rel_trabajador_area_operativa.id=registro_verificacion.id_primer_verificador || rel_trabajador_area_operativa.id=registro_verificacion.id_segundo_verificador)  and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=3) as MARZO,
                                            (select count(*) from registro_verificacion where (rel_trabajador_area_operativa.id=registro_verificacion.id_primer_verificador || rel_trabajador_area_operativa.id=registro_verificacion.id_segundo_verificador)  and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=4) as ABRIL,
                                            (select count(*) from registro_verificacion where (rel_trabajador_area_operativa.id=registro_verificacion.id_primer_verificador || rel_trabajador_area_operativa.id=registro_verificacion.id_segundo_verificador)  and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=5) as MAYO,
                                            (select count(*) from registro_verificacion where (rel_trabajador_area_operativa.id=registro_verificacion.id_primer_verificador || rel_trabajador_area_operativa.id=registro_verificacion.id_segundo_verificador)  and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=6) as JUNIO,
                                            (select count(*) from registro_verificacion where (rel_trabajador_area_operativa.id=registro_verificacion.id_primer_verificador || rel_trabajador_area_operativa.id=registro_verificacion.id_segundo_verificador)  and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=7) as JULIO,
                                            (select count(*) from registro_verificacion where (rel_trabajador_area_operativa.id=registro_verificacion.id_primer_verificador || rel_trabajador_area_operativa.id=registro_verificacion.id_segundo_verificador)  and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=8) as AGOSTO,
                                            (select count(*) from registro_verificacion where (rel_trabajador_area_operativa.id=registro_verificacion.id_primer_verificador || rel_trabajador_area_operativa.id=registro_verificacion.id_segundo_verificador)  and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=9) as SEPTIEMBRE,
                                            (select count(*) from registro_verificacion where (rel_trabajador_area_operativa.id=registro_verificacion.id_primer_verificador || rel_trabajador_area_operativa.id=registro_verificacion.id_segundo_verificador)  and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=10) as OCTUBRE,
                                            (select count(*) from registro_verificacion where (rel_trabajador_area_operativa.id=registro_verificacion.id_primer_verificador || rel_trabajador_area_operativa.id=registro_verificacion.id_segundo_verificador)  and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=11) as NOVIEMBRE,
                                            (select count(*) from registro_verificacion where (rel_trabajador_area_operativa.id=registro_verificacion.id_primer_verificador || rel_trabajador_area_operativa.id=registro_verificacion.id_segundo_verificador)  and deleted_at is null $filtro and YEAR(fecha_orden)=2018 and MONTH(fecha_orden)=12) as DICIEMBRE,
                                            (select count(*) from registro_verificacion where (rel_trabajador_area_operativa.id=registro_verificacion.id_primer_verificador || rel_trabajador_area_operativa.id=registro_verificacion.id_segundo_verificador)  and deleted_at is null $filtro and YEAR(fecha_orden)=2018) as TOTAL"));    
                                            
        if($parametros['id_area_operativa'] != 0)
        {
            
            $registro_trabajador = $registro_trabajador->where("rel_trabajador_area_operativa.id_catalogo_area_operativa", "=", $parametros['id_area_operativa']);
        }   
        $registro_trabajador = $registro_trabajador->get(); 
        
        $arreglo_respuesta = Array("Tipo_Acta"=>$registro_tipo_acta, "Area_Operativa"=>$registro_area_operativa, "Motivo_Verificacion"=> $registro_motivo_verificacion, "Medida_Seguridad"=>$registro_medida_seguridad, "Giro"=>$registro_giro, "Trabajador"=> $registro_trabajador, "Titulo_Filtro"=> $titulo_filtro);
        return Response::json([ 'data' => $arreglo_respuesta],200);
                        
    }
}
