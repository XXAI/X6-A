<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Avisos extends Model
{
    use SoftDeletes;
    
    protected $generarID = false;
    protected $guardarIDServidor = false;
    protected $guardarIDUsuario = true;
    public $incrementing = true;

    
    protected $table = 'registro_aviso';  
    protected $fillable = ["no", "id_giro", "establecimiento", "fecha_alta", "modificacion_datos", "fecha_baja", "usuario_id"];

    public function giro(){
        return $this->belongsTo('App\Models\CatalogoGiro', 'id_giro');
    }
}
