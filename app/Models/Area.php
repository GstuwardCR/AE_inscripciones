<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table = 'simulacroAdm_area'; 
    protected $primaryKey = 'idAdm_area'; 
    public $timestamps = false; 

    protected $fillable = [
        'nombre',
        'descripcion',
        'desc_ficha',
        'estado',
    ];
}
