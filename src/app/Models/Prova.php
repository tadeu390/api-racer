<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Prova\ProvaMutator;

class Prova extends Model
{
    use ProvaMutator;
    use SoftDeletes;

    /**
     * Table associated with this model
     *
     * @var array
     */
    protected $table = 'provas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo_prova', 'data',
    ];

    /**
     * Date type attributes
     *
     * @var array
     */
    protected $dates = [
        'deleted_at', 'data',
    ];

    public function corredores()
    {
        return $this->belongsToMany(Corredor::class);
    }
}
