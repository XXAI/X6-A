<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class DenunciaSeguimiento extends BaseModel
{
    use SoftDeletes;
    
    protected $generarID = false;
    protected $guardarIDServidor = false;
    protected $guardarIDUsuario = true;
    public $incrementing = true;

    
    protected $table = 'denuncia_seguimiento';  
    protected $fillable = ["denuncia_id", "seguimiento", "usuario_id", "idEstatus" ];

    public function usuario(){
        return $this->belongsTo('App\Models\Usuario', 'usuario_id', 'id');
    }
}
