<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Corredor extends Model
{
    use SoftDeletes;

    /**
     * Table associated with this model
     *
     * @var array
     */
    protected $table = 'corredores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'cpf', 'data_nascimento',
    ];

    /**
     * Date type attributes
     *
     * @var array
     */
    protected $dates = [
        'deleted_at', 'data_nascimento',
    ];

    /**
     * Relationship
     */
    public function provas()
    {
        return $this->belongsToMany(Prova::class);
    }

    public function resultados()
    {
        return $this->hasManyThrough(Resultado::class, CorredorProva::class);
    }
}
