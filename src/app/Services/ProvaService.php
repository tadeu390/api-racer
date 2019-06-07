<?php
namespace App\Services;

use App\Repositories\Contracts\ProvaRepositoryInterface;

class ProvaService
{
    /**
     * @var ProvaRepositoryInterface
     */
    protected $repository;

    public function __construct(ProvaRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
