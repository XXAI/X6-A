<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;

use App\Models\Denuncia, App\Models\DenunciaSeguimiento;

class SeguimientoDenunciaController extends Controller
{
    public function index(Request $request)
    {
        $parametros = Input::only('status','q','page','per_page', 'text', 'estatus');

        //return Response::json([ 'data' => $parametros],200); 
        $denuncia = Denuncia::whereNull("deleted_at");
        
        if(isset($parametros['text']) && $parametros['text']!='')
        {
            $denuncia =  $denuncia->where(function($query) use ($parametros) {
                $query->where('razon_social','LIKE',"%".$parametros['text']."%")
                        ->orWhere('giro','LIKE',"%".$parametros['text']."%")
                        ->orWhere('producto','LIKE',"%".$parametros['text']."%");
            });
        }

        if(isset($parametros['estatus']) && $parametros['estatus']!=0)
        {
            $denuncia = $denuncia->where("idEstatus", "=", $parametros['estatus']);
        }

        if(isset($parametros['page'])){
            $resultadosPorPagina = isset($parametros["per_page"])? $parametros["per_page"] : 25;
            //$denuncia = $denuncia-> "desc");
            $denuncia = $denuncia->paginate($resultadosPorPagina);
        } else {
            $denuncia = $denuncia->get();
        }
        
        return Response::json([ 'data' => $denuncia],200); 
                        
    }

    public function show($id)
    {
        try{
            DB::beginTransaction();
            $registro = Denuncia::with("catalogoEntidadPersona","catalogoMunicipioPersona","catalogoLocalidadPersona", "catalogoEntidadDenuncia","catalogoMunicipioDenuncia", "seguimiento.usuario")->find($id);
            DB::commit();
            return Response::json([ 'data' => $registro ],200);

        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        }
    }

    public function update(Request $request, $id)
    {
        $mensajes = [
            'required'      => "required",
        ];

        $reglas = [
            "seguimiento"=> 'required',
            "idEstatus"=> 'required'
        ];

        $parametros = Input::all();

        $parametros['seguimiento'] = strtoupper($parametros['seguimiento']);
        
        $v = Validator::make($parametros, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }

        try {
            DB::beginTransaction();
            $denuncia = Denuncia::find($id);
            if($denuncia->idEstatus !=3 && $denuncia->idEstatus !=4)
            {
                $parametros['denuncia_id'] = $id;
                $seguimiento = DenunciaSeguimiento::create($parametros);
                
                
                $denuncia->idEstatus = $parametros['idEstatus'];
                $denuncia->update();
            }else{
                return Response::json(['error' => 'No se puede registrar el nuevo seguimiento, por que se encuentra en estatus: no procede o concluido.'], 500);
            }
           
            DB::commit();
            return Response::json([ 'data' => $denuncia ],200);

        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        }
    }
}
