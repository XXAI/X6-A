<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class ResolucionAdministrativa extends BaseModel
{
    use SoftDeletes;
    
    protected $generarID = false;
    protected $guardarIDServidor = false;
    protected $guardarIDUsuario = true;
    public $incrementing = true;

    
    protected $table = 'registro_resolucion';  
    protected $fillable = ["no", "id_area_operativa", "id_resolutor","no_expediente", "fecha_recepcion", "id_giro", "establecimiento", "id_procedencia", "no_citatorio", "fecha_notificacion_citatorio", "fecha_comparecencia", "no_resolucion", "fecha_emision", "id_sancion", "fecha_notificacion_resolucion", "id_estatus", "id_recurso_conformidad", "fecha_envio_juridico", "fecha_envio_resolucion", "observaciones", "usuario_id"];

    public function areaOperativa(){
        return $this->belongsTo('App\Models\CatalogoAreaOperativa', 'id_area_operativa');
    }

    public function estatus(){
        return $this->belongsTo('App\Models\CatalogoEstatusDocumento', 'id_estatus');
    }

    public function giro(){
        return $this->belongsTo('App\Models\CatalogoGiro', 'id_giro');
    }
}
