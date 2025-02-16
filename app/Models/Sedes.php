<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sedes extends Model
{
    use HasFactory;

    protected $table = 'inst_local'; 

    protected $primaryKey = 'id'; 

    public $timestamps = false; 

    protected $fillable = [
        'loc_id',        
        'loc_desc',      
        'loc_dire',      
        'loc_esta',      
        'fecha_registro',
        'fecha_actualizacion'
    ];

    /**
     * Mutador para establecer la fecha de actualización automáticamente.
     */
    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->fecha_actualizacion = now();
        });
    }
}
