<?php
namespace App\Services;

use App\Repositories\Contracts\ResultadoRepositoryInterface;

class ResultadoService
{
    /**
     * @var ResultadoRepositoryInterface
     */
    protected $repository;

    public function __construct(ResultadoRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
