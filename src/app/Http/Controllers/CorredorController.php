<?php

namespace App\Http\Controllers;

use App\Services\CorredorService;
use App\Http\Requests\CorredorRequest;

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
        if ($result->message == 'success') {
            return response()->json($result->object, $result->code);
        }

        return response()->json($result->message, $result->code);
    }
}
