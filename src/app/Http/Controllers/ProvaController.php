<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProvaRequest;
use App\Services\ProvaService;
use App\Http\Requests\CorredorProvaRequest;

class ProvaController extends Controller
{
    /**
     * @var ProvaService
     */
    protected $prova;

    /**
     * Injeta as dependências necessárias.
     */
    public function __construct(ProvaService $prova)
    {
        $this->prova = $prova;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\ProvaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProvaRequest $request)
    {
        $result = $this->prova->store($request->all());
        if ($result->message == 'success') {
            return response()->json($result->object, $result->code);
        }

        return response()->json($result->message, $result->code);
    }

    /**
     * Envia para a camada de regra de negócio o corredor e a prova a serem relacionados.
     *
     * @param  \Illuminate\Http\Requests\CorredorProvaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function storeCorredorProva(CorredorProvaRequest $request)
    {
        $result = $this->prova->storeCorredorProva($request->all());
        if ($result->message == 'success') {
            return response()->json($result->object, $result->code);
        }

        return response()->json($result->message, $result->code);
    }
}
