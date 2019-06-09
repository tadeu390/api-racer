<?php

namespace App\Services;

use App\Repositories\Contracts\ResultadoRepositoryInterface;
use Mockery\Exception;

/**
 * Camada de serviço referente as regras de negócio do resultado das provas.
 */
class ResultadoService
{
    /**
     * @var ResultadoRepositoryInterface
     */
    protected $repository;

    /**
     * @var ProvaService
     */
    protected $prova_service;

    /**
     * Reponsável por injetar as dependências necessárias.
     */
    public function __construct(ResultadoRepositoryInterface $repository, ProvaService $prova_service)
    {
        $this->repository = $repository;
        $this->prova_service = $prova_service;
    }

    /**
     * Responsável por cadastrar um resultado de uma prova para um corredor.
     *
     * @param array $data
     *
     * @return object
     */
    public function store(array $data)
    {
        try {
            $this->validaRegras($data);
            $model = $this->repository->store($data);

            return [
                'success' => true,
                'message' => 'Resultado cadastrado com sucesso.',
                'data'    => $model,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro de execução',
                'data'    => $e->getMessage()
            ];
        }
    }

    /**
     * Responsável por chamar todos os métodos que aplicam as regras de negócio.
     *
     * @param array $data
     */
    protected function validaRegras(array $data)
    {
        $this->prova_service->validaCorredor($data['corredor_id']);
        $this->prova_service->validaProva($data['prova_id']);
        if (!$this->prova_service->corredorProvaExiste($data)) {
            throw new Exception('O corredor informado não se encontra cadastrado para esta prova.');
        }
        $this->validaResultado($data);
    }

    /**
     * Responsável por verificar se já existe um resultado cadastrado para um corredor em uma prova.
     *
     * @param array $data
     */
    protected function validaResultado($data)
    {
        $resultado = \App\Models\Resultado::where('corredor_id', $data['corredor_id'])->where('prova_id', $data['prova_id'])->get();

        if (count($resultado)) {
            throw new Exception('Este resultado já se encontra cadastrado na base de dados.');
        }
    }

    /**
     * Lista as classificações por idade com base no tipo de prova.
     *
     * @param string $tipo_prova
     *
     * @return object
     */
    public function listaPorIdade($tipo_prova)
    {
        try {
            $model = $this->repository->listaPorIdade($tipo_prova);

            return [
                'success' => true,
                'message' => 'Busca realizada com sucesso.',
                'data'    => $model,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro de execução',
                'data'    => $e->getMessage()
            ];
        }
    }

    /**
     * Lista as classificações por idade com base no tipo de prova.
     *
     * @return object
     */
    public function listaGeral()
    {
        try {
            $model = $this->repository->listaGeral();

            return [
                'success' => true,
                'message' => 'Busca realizada com sucesso.',
                'data'    => $model,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro de execução',
                'data'    => $e->getMessage()
            ];
        }
    }
}
