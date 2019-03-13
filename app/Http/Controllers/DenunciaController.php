<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;

use App\Models\Denuncia;

class DenunciaController extends Controller
{

    public function show($id)
    {
        try{
            DB::beginTransaction();
            $registro = Denuncia::with("catalogoEntidadPersona","catalogoMunicipioPersona","catalogoLocalidadPersona", "catalogoEntidadDenuncia","catalogoMunicipioDenuncia", "seguimiento.usuario")->where("codigo", "=", $id)->first();
            DB::commit();
            return Response::json([ 'data' => $registro ],200);

        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        }
    }

    public function store(Request $request)
    {
        $mensajes = [
            'required'      => "required",
        ];

        $reglas = [
            'anonimo'        => 'required',
            'correo'        => 'required',
            'lada'        => 'required',
            'telefono'        => 'required',
            //'ext'        => 'required',
            "estado_persona"=> 'required', 
            "municipio_persona"=> 'required',
            "localidad_persona"=> 'required', 
            "razon_social"=> 'required',
            "giro"=> 'required',
            "estado_denuncia"=> 'required',
            "municipio_denuncia"=> 'required',
            "narracion"=> 'required'
        ];

        $parametros = Input::all();
        
        $v = Validator::make($parametros, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }

        try {
            $codigo = '';
            do {
                $codigo = $this->generateCode(6);
            } while (Denuncia::where("codigo", "=", $codigo)->first() instanceof Denuncia);

            $parametros['codigo'] = $codigo;
            $Denuncia = Denuncia::create($parametros);
            return Response::json([ 'data' => $Denuncia ],200);

        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        }
    }

    
    private function generateCode($longitud){
        $key = '';
        $pattern = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
        return $key;
    }

}
