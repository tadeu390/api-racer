<?php

namespace App\Http\Controllers;

use App\Services\CorredorService;
use App\Http\Requests\CorredorRequest;
use App\Http\Resources\CorredorResource;
use Symfony\Component\HttpFoundation\Response;

/**
 * Classe controladora dos recursos referente aos corredores.
 */
class CorredorController extends Controller
{
    /**
     * @var CorredorService
     */
    protected $corredor;

    /**
     * Injeta as dependências necessárias.
     */
    public function __construct(CorredorService $corredor)
    {
        $this->corredor = $corredor;
    }

    /**
     * Envia para a camada de regra de negócios os dados de um corredor.
     *
     * @param  \Illuminate\Http\Requests\CorredorRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CorredorRequest $request)
    {
        $result = $this->corredor->store($request->all());

        return (new CorredorResource($result))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
