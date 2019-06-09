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
            $data['corredor_prova_id'] = $this->prova_service->corredorProvaExiste($data);

            $object = $this->repository->store($data);

            $object = $this->actions($object);

            return (object) [
                'message' => 'success',
                'object' => $object,
                'code' => 201,
            ];
        } catch (\Exception $e) {
            $code = $e->getCode();
            if ($code == 0) {
                $code = 400;
            }

            return (object) [
                'message' => $e->getMessage(),
                'code' => $code,
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
        if ($this->prova_service->corredorProvaExiste($data) == 0) {
            throw new Exception('O corredor informado não se encontra cadastrado para esta prova.', 422);
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
        $corredor_prova_id = $this->prova_service->corredorProvaExiste($data);

        $resultado = $this->repository->findWhereFirst('corredor_prova_id', $corredor_prova_id);

        if ($resultado) {
            throw new Exception('Este resultado já se encontra cadastrado na base de dados.', 422);
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
            $object = $this->repository->listaPorIdade($tipo_prova);
            $object = $this->actionsListaPorIdade($object);

            return (object) [
                'message' => 'success',
                'object' => $object,
                'code' => 200,
            ];
        } catch (\Exception $e) {
            $code = $e->getCode();
            if ($code == 0) {
                $code = 400;
            }

            return (object) [
                'message' => $e->getMessage(),
                'code' => $code,
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
            $object = $this->repository->listaGeral();
            $object = $this->actionsListaGeral($object);

            return (object) [
                'message' => 'success',
                'object' => $object,
                'code' => 200,
            ];
        } catch (\Exception $e) {
            $code = $e->getCode();
            if ($code == 0) {
                $code = 400;
            }

            return (object) [
                'message' => $e->getMessage(),
                'code' => $code,
            ];
        }
    }

    /**
     * Responsável por adicionar navegações.(HATEOAS)
     *
     * @param array $object
     *
     * @return array
     */
    protected function actions($object)
    {
        $ob = new \stdClass;
        $ob->url = url('/provas/resultados');
        $ob->object = $object;

        return $ob;
    }

    /**
     * Responsável por adicionar navegações.(HATEOAS)
     *
     * @param array $object
     *
     * @return array
     */
    protected function actionsListaGeral($object)
    {
        $ob = new \stdClass;
        $ob->url = url('/provas/classificacoes/geral');
        $ob->object = $object;

        return $ob;
    }

    /**
     * Responsável por adicionar navegações.(HATEOAS)
     *
     * @param Object $object
     *
     * @return Object
     */
    protected function actionsListaPorIdade($object)
    {
        $ob = new \stdClass;
        $ob->url = url("provas/classificacoes/idade/{$object[0]->tipo_prova}");
        $ob->object = $object;

        return $ob;
    }
}
