<?php
namespace App\Repositories\Core;

use App\Repositories\Core\BaseEloquent\BaseEloquentRepository;
use App\Repositories\Contracts\CorredorRepositoryInterface;
use App\Models\Corredor;

class EloquentCorredorRepository extends BaseEloquentRepository implements CorredorRepositoryInterface
{
    public function entity()
    {
        return Corredor::class;
    }
}
