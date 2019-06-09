<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProvaRequest;
use App\Services\ProvaService;
use App\Http\Requests\CorredorProvaRequest;
use App\Http\Requests\ResultadoRequest;
use App\Services\ResultadoService;
use App\Http\Resources\ProvaResource;
use App\Http\Resources\ResultadoResource;
use Symfony\Component\HttpFoundation\Response;

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
        $model = $this->prova->store($request->all());

        return (new ProvaResource($model))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
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
        $model = $this->prova->storeCorredorProva($request->all());

        return (new ProvaResource($model))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Envia para a camada de regra de negócio o resultado de um corredor em uma prova.
     *
     * @param  \Illuminate\Http\Requests\ResultadoRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function storeResultados(ResultadoRequest $request)
    {
        $model = $this->resultado->store($request->all());

        return (new ResultadoResource($model))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
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
        $model = $this->resultado->listaPorIdade($tipo_prova);

        return (new ResultadoResource($model))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Solicita a camada de regras de negócios a lista geral.
     *
     * @return \Illuminate\Http\Response
     */
    public function listaGeral()
    {
        $model = $this->resultado->listaGeral();

        return (new ResultadoResource($model))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
