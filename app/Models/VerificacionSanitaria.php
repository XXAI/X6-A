<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class VerificacionSanitaria extends BaseModel
{
    use SoftDeletes;
    
    protected $generarID = false;
    protected $guardarIDServidor = false;
    protected $guardarIDUsuario = true;
    public $incrementing = true;

    
    protected $table = 'registro_verificacion';  
    protected $fillable = ["no", "no_orden", "fecha_orden", "id_area_operativa", "id_motivo_orden_verificacion","id_fiscalia", "id_toma_muestra", "id_giro", "establecimiento", "fecha_acta", "id_tipo_acta", "id_primer_verificador", "id_segundo_verificador", "id_medida_seguridad", "motivo_suspension", "fecha_envio_dictamen", "usuario_id"];

    public function areaOperativa(){
        return $this->belongsTo('App\Models\CatalogoAreaOperativa', 'id_area_operativa');
    }

    public function fiscalia(){
        return $this->belongsTo('App\Models\CatalogoFiscalia', 'id_fiscalia');
    }

    public function giro(){
        return $this->belongsTo('App\Models\CatalogoGiro', 'id_giro');
    }
}
