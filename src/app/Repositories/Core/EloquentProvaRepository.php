<?php

namespace App\Repositories\Core;

use App\Repositories\Core\BaseEloquent\BaseEloquentRepository;
use App\Repositories\Contracts\ProvaRepositoryInterface;
use App\Models\Prova;

/**
 * Camada de repositório. Classe que implementa os métodos da interface de Prova.
 */
class EloquentProvaRepository extends BaseEloquentRepository implements ProvaRepositoryInterface
{
    /**
     * Retorna o modelo usado para manipular dados no banco.
     */
    public function entity()
    {
        return Prova::class;
    }
}
