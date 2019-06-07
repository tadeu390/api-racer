<?php
namespace App\Repositories\Core;

use App\Repositories\Core\BaseEloquent\BaseEloquentRepository;
use App\Repositories\Contracts\ResultadoRepositoryInterface;
use App\Models\Resultado;

class EloquentResultadoRepository extends BaseEloquentRepository implements ResultadoRepositoryInterface
{
    public function entity()
    {
        return Resultado::class;
    }
}
