<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    use HasFactory;

    protected $fillable = [
        "nombre",
        "tipo_dato",
        "es_pk",
        "es_fk",
        "es_null",
        "valor_defecto",
        "descripcion",
    ];
}
