<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProvaRequest;
use App\Services\ProvaService;
use App\Http\Requests\CorredorProvaRequest;
use App\Http\Requests\ResultadoRequest;
use App\Services\ResultadoService;

/**
 * Classe controladora de recursos referentes a provas.
 */
class ProvaController extends Controller
{
    /**
     * @var ProvaService
     */
    protected $prova;

    /**
     * @var ResultadoService
     */
    protected $resultado;

    /**
     * Injeta as dependências necessárias.
     */
    public function __construct(ProvaService $prova, ResultadoService $resultado)
    {
        $this->prova = $prova;
        $this->resultado = $resultado;
    }

    /**
     * Envia os dados de uma prova para a camada de regras de negócios.
     *
     * @param  \Illuminate\Http\Requests\ProvaRequest $request
     *
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
     *
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

    /**
     * Envia para a camada de regra de negócio o resultado de um corredor em uma prova.
     *
     * @param  \Illuminate\Http\Requests\ResultadoRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function resultados(ResultadoRequest $request)
    {
        $result = $this->resultado->store($request->all());
        if ($result->message == 'success') {
            return response()->json($result->object, $result->code);
        }

        return response()->json($result->message, $result->code);
    }

    /**
     * Solicita a camada de regras de neǵocios a lista por idade.
     *
     * @param string $tipo_prova
     *
     * @return \Illuminate\Http\Response
     */
    public function listaPorIdade($tipo_prova = null)
    {
        if ($tipo_prova == null) {
            return response()->json('Argumento tipo da prova não foi informado.', 400);
        }

        $result = $this->resultado->listaPorIdade($tipo_prova);
        if ($result->message == 'success') {
            return response()->json($result->object, $result->code);
        }

        return response()->json($result->message, $result->code);
    }

    /**
     * Solicita a camada de regras de negócios a lista geral.
     *
     * @return \Illuminate\Http\Response
     */
    public function listaGeral()
    {
        $result = $this->resultado->listaGeral();
        if ($result->message == 'success') {
            return response()->json($result->object, $result->code);
        }

        return response()->json($result->message, $result->code);
    }
}
