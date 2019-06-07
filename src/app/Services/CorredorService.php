<?php
namespace App\Services;

use App\Repositories\Contracts\CorredorRepositoryInterface;

class CorredorService
{
    /**
     * @var CorredorRepositoryInterface
     */
    protected $repository;

    public function __construct(CorredorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
