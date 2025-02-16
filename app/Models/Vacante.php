<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacante extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'simulacroAdm_detalle_interno';

    // The primary key for the table
    protected $primaryKey = 'idAdm_det_int';

    // Disabling auto-increment if the primary key is not auto-increment
    public $incrementing = true;
    public $timestamps = false; 

    // Specify the fields that are mass assignable
    protected $fillable = [
        'idAdm_det', 
        'vac_ini', 
        'vac_fin', 
        'loc_id', 
        'ini_id', 
        'aul_id', 
        'tur_id', 
        'tipo_evento', 
        'estado', 
        'fecha_registro'
    ];

    // Specify the default values for the attributes
    protected $attributes = [
        'vac_ini' => 0,
        'vac_fin' => 0,
        'loc_id' => '0',
        'ini_id' => '0',
        'aul_id' => '0',
        'tur_id' => '0',
        'tipo_evento' => 'PRESENCIAL',
        'estado' => 1,
    ];

    // Specify that the 'fecha_registro' is a timestamp
    protected $casts = [
        'fecha_registro' => 'datetime',
    ];

    
}
