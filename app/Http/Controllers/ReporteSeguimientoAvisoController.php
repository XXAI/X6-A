<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\CatalogoGiro;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;

class ReporteSeguimientoAvisoController extends Controller
{
    public function index(Request $request)
    {
        $parametros = $parametros = Input::only('status','q','page','per_page', 'id_area_operativa');

        $filtro = "";
        $titulo_filtro = "TODOS";
        if($parametros['id_area_operativa'] != 0)
        {
            //$filtro = " and registro_aviso.id_area_operativa=".$parametros['id_area_operativa'];
            //$tabla_area_operativa = CatalogoAreaOperativa::find($parametros['id_area_operativa']);
            //$titulo_filtro = $tabla_area_operativa->descripcion;
        }


        
        $registro_altas = DB::table("registro_aviso as ra")
                                            ->whereNull("ra.deleted_at")
                                            ->where("ra.fecha_alta", ">=", date("Y")."-01-01")
                                            ->select(
                                                    DB::RAW("(select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=1) as ENERO,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=2) as FEBRERO,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=3) as MARZO,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=4) as ABRIL,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=5) as MAYO,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=6) as JUNIO,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=7) as JULIO,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=8) as AGOSTO,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=9) as SEPTIEMBRE,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=10) as OCTUBRE,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=11) as NOVIEMBRE,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=12) as DICIEMBRE,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y").") as TOTAL"))
                                            ->get();   

        $registro_modificacion = DB::table("registro_aviso as ra")
                                            ->whereNull("ra.deleted_at")
                                            ->where("ra.modificacion_datos", ">=", date("Y")."-01-01")
                                            ->select(
                                                    DB::RAW("(select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(modificacion_datos)=".date("Y")." and MONTH(modificacion_datos)=1) as ENERO,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(modificacion_datos)=".date("Y")." and MONTH(modificacion_datos)=2) as FEBRERO,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(modificacion_datos)=".date("Y")." and MONTH(modificacion_datos)=3) as MARZO,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(modificacion_datos)=".date("Y")." and MONTH(modificacion_datos)=4) as ABRIL,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(modificacion_datos)=".date("Y")." and MONTH(modificacion_datos)=5) as MAYO,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(modificacion_datos)=".date("Y")." and MONTH(modificacion_datos)=6) as JUNIO,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(modificacion_datos)=".date("Y")." and MONTH(modificacion_datos)=7) as JULIO,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(modificacion_datos)=".date("Y")." and MONTH(modificacion_datos)=8) as AGOSTO,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(modificacion_datos)=".date("Y")." and MONTH(modificacion_datos)=9) as SEPTIEMBRE,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(modificacion_datos)=".date("Y")." and MONTH(modificacion_datos)=10) as OCTUBRE,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(modificacion_datos)=".date("Y")." and MONTH(modificacion_datos)=11) as NOVIEMBRE,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(modificacion_datos)=".date("Y")." and MONTH(modificacion_datos)=12) as DICIEMBRE,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(modificacion_datos)=".date("Y").") as TOTAL"))
                                            ->get();       
                                            
        $registro_baja = DB::table("registro_aviso as ra")
                                            ->whereNull("ra.deleted_at")
                                            ->where("ra.fecha_baja", ">=", date("Y")."-01-01")
                                            ->select(
                                                    DB::RAW("(select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_baja)=".date("Y")." and MONTH(fecha_baja)=1) as ENERO,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_baja)=".date("Y")." and MONTH(fecha_baja)=2) as FEBRERO,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_baja)=".date("Y")." and MONTH(fecha_baja)=3) as MARZO,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_baja)=".date("Y")." and MONTH(fecha_baja)=4) as ABRIL,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_baja)=".date("Y")." and MONTH(fecha_baja)=5) as MAYO,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_baja)=".date("Y")." and MONTH(fecha_baja)=6) as JUNIO,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_baja)=".date("Y")." and MONTH(fecha_baja)=7) as JULIO,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_baja)=".date("Y")." and MONTH(fecha_baja)=8) as AGOSTO,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_baja)=".date("Y")." and MONTH(fecha_baja)=9) as SEPTIEMBRE,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_baja)=".date("Y")." and MONTH(fecha_baja)=10) as OCTUBRE,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_baja)=".date("Y")." and MONTH(fecha_baja)=11) as NOVIEMBRE,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_baja)=".date("Y")." and MONTH(fecha_baja)=12) as DICIEMBRE,
                                                    (select count(*) from registro_aviso where deleted_at is null $filtro and YEAR(fecha_baja)=".date("Y").") as TOTAL"))
                                            ->get();            
                                            
        
                                            
        $registro_giro = CatalogoGiro::select("id", "descripcion",
                                            DB::RAW("(select count(*) from registro_aviso where catalogo_giro.id=registro_aviso.id_giro and deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=1) as ENERO,
                                            (select count(*) from registro_aviso where catalogo_giro.id=registro_aviso.id_giro and deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=2) as FEBRERO,
                                            (select count(*) from registro_aviso where catalogo_giro.id=registro_aviso.id_giro and deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=3) as MARZO,
                                            (select count(*) from registro_aviso where catalogo_giro.id=registro_aviso.id_giro and deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=4) as ABRIL,
                                            (select count(*) from registro_aviso where catalogo_giro.id=registro_aviso.id_giro and deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=5) as MAYO,
                                            (select count(*) from registro_aviso where catalogo_giro.id=registro_aviso.id_giro and deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=6) as JUNIO,
                                            (select count(*) from registro_aviso where catalogo_giro.id=registro_aviso.id_giro and deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=7) as JULIO,
                                            (select count(*) from registro_aviso where catalogo_giro.id=registro_aviso.id_giro and deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=8) as AGOSTO,
                                            (select count(*) from registro_aviso where catalogo_giro.id=registro_aviso.id_giro and deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=9) as SEPTIEMBRE,
                                            (select count(*) from registro_aviso where catalogo_giro.id=registro_aviso.id_giro and deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=10) as OCTUBRE,
                                            (select count(*) from registro_aviso where catalogo_giro.id=registro_aviso.id_giro and deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=11) as NOVIEMBRE,
                                            (select count(*) from registro_aviso where catalogo_giro.id=registro_aviso.id_giro and deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y")." and MONTH(fecha_alta)=12) as DICIEMBRE,
                                            (select count(*) from registro_aviso where catalogo_giro.id=registro_aviso.id_giro and deleted_at is null $filtro and YEAR(fecha_alta)=".date("Y").") as TOTAL"))
                                            ->get();     
                                            
        
        
        $araeglo_respuesta = Array( "Altas"=>$registro_altas, "Modificacion"=> $registro_modificacion, "Bajas"=> $registro_baja,"Giro"=>$registro_giro, "Titulo_Filtro"=> $titulo_filtro);
        return Response::json([ 'data' => $araeglo_respuesta],200);
                        
    }
}
