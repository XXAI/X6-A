<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class LicenciasSanitarias extends BaseModel
{
    use SoftDeletes;
    
    protected $generarID = false;
    protected $guardarIDServidor = false;
    protected $guardarIDUsuario = true;
    public $incrementing = true;

    
    protected $table = 'registro_licencia';  
    protected $fillable = ["no", "no_solicitud", "fecha_recepcion", "id_giro", "establecimiento", "id_verificacion_sanitaria", "id_dictamen", "id_notificacion", "no_licencia", "fecha_emision", "fecha_entrega", "id_estatus", "usuario_id"];

    public function estatus(){
        return $this->belongsTo('App\Models\CatalogoEstatusDocumento', 'id_estatus');
    }

    public function giro(){
        return $this->belongsTo('App\Models\CatalogoGiro', 'id_giro');
    }
}
