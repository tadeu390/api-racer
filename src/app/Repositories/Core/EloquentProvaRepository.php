<?php
namespace App\Repositories\Core;

use App\Repositories\Core\BaseEloquent\BaseEloquentRepository;
use App\Repositories\Contracts\ProvaRepositoryInterface;
use App\Models\Prova;

class EloquentProvaRepository extends BaseEloquentRepository implements ProvaRepositoryInterface
{
    public function entity()
    {
        return Prova::class;
    }
}
