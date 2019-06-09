<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resultado extends Model
{
    use SoftDeletes;

    /**
     * Table associated with this model
     *
     * @var array
     */
    protected $table = 'resultados';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'horario_inicio', 'horario_fim', 'corredor_id', 'prova_id',
    ];

    /**
     * Date type attributes
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];
}
