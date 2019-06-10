<?php

namespace App\Repositories\Core;

use App\Repositories\Core\BaseEloquent\BaseEloquentRepository;
use App\Repositories\Contracts\CorredorRepositoryInterface;
use App\Models\Corredor;

/**
 * Camada de repositório. Classe que implementa os métodos da interface de Corredor.
 */
class EloquentCorredorRepository extends BaseEloquentRepository implements CorredorRepositoryInterface
{
    /**
     * Retorna o model de Corredor para realizar alterações no modelo na base de dados.
     */
    public function entity()
    {
        return Corredor::class;
    }
}
