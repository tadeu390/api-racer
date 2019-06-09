<?php

namespace App\Services;

use App\Repositories\Contracts\ProvaRepositoryInterface;
use App\Repositories\Contracts\CorredorRepositoryInterface;
use Carbon\Carbon;
use Mockery\CountValidator\Exception;

/**
 * Camada de regra de negócio referente as provas dos corredores.
 */
class ProvaService
{
    /**
     * @var ProvaRepositoryInterface
     */
    protected $repository;

    /**
     * @var CorredorRepositoryInterface
     */
    protected $corredor_repo;

    /**
     * Injeta as dependências necessárias.
     */
    public function __construct(ProvaRepositoryInterface $repository, CorredorRepositoryInterface $corredor_repo)
    {
        $this->repository = $repository;
        $this->corredor_repo = $corredor_repo;
    }

    /**
     * Responsável por cadastrar uma nova prova.
     *
     * @param array $data
     *
     * @return object
     */
    public function store(array $data)
    {
        try {
            $prova = $this->repository->store($data);

            $prova = $this->actions($prova);

            return (object) [
                'message' => 'success',
                'object' => $prova,
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
     * Cadastra um corredor em prova.
     *
     * @param array $data
     *
     * @return object
     */
    public function storeCorredorProva(array $data)
    {
        try {
            $this->validaRegras($data);
            $object = $this->repository->findById($data['prova_id']);
            $object->corredores()->attach($data['corredor_id']);

            $object = $this->actionsCorredorProva($data['corredor_id'], $data['prova_id']);

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
        $this->validaCorredor($data['corredor_id']);
        $this->validaProva($data['prova_id']);
        $this->validaCorredorProva($data);
        $this->validaCorredorProvaData($data);
    }

    /**
     * Responsável por verificar se existe um corredor com o id informado.
     *
     * @param int $corredor_id
     */
    public function validaCorredor($corredor_id)
    {
        $corredor = $this->corredor_repo->findById($corredor_id);

        if (!$corredor) {
            throw new Exception('o Id informado para o corredor não existe na base de dados.', 404);
        }
    }

    /**
     * Responsável por verificar se existe uma prova com o id informado.
     *
     * @param int $prova_id
     */
    public function validaProva($prova_id)
    {
        $prova = $this->repository->findById($prova_id);

        if (!$prova) {
            throw new Exception('o Id informado para a prova não existe na base de dados.', 404);
        }
    }

    /**
     * Responsável por verificar se o corredor já se encontra na prova em questão.
     *
     * @param array $data
     */
    protected function validaCorredorProva(array $data)
    {
        if ($this->corredorProvaExiste($data) != 0) {
            throw new Exception('O corredor informado já se encontra cadastrado para esta prova.', 422);
        }
    }

    /**
     * Responsável por verificar se o corredor já se encontra numa outra pŕova com a mesma data.
     *
     * @param array $data
     */
    protected function validaCorredorProvaData(array $data)
    {
        $corredor = $this->corredor_repo->findById($data['corredor_id']);
        $data_prova = $this->repository->findById($data['prova_id'])->data;
        $data_prova = Carbon::parse($data_prova)->format('Y-m-d');

        foreach ($corredor->provas as $prova) {
            $data_prova_corredor = Carbon::parse($prova->data)->format('Y-m-d');

            if ($data_prova_corredor == $data_prova) {
                throw new Exception('O corredor informado já se encontra cadastrado em outra prova que possui a mesma data da prova informada.', 422);
            }
        }
    }

    /**
     * Responsável por verificar se um corredor está cadastrado para uma prova.
     *
     * @param array $data
     *
     * @return int
     */
    public function corredorProvaExiste(array $data)
    {
        $prova = $this->repository->findById($data['prova_id']);

        foreach ($prova->corredores as $corredor) {
            if ($corredor->id == $data['corredor_id']) {
                return $corredor->pivot->id;
            }
        }

        return 0;
    }

    /**
     * Responsável por adicionar navegações.(HATEOAS)
     *
     * @param array $object
     *
     * @return Object
     */
    protected function actions($prova)
    {
        $ob = new \stdClass;
        $ob->url = url('/provas');
        $ob->object = $prova;

        return $ob;
    }

    /**
     * Responsável por adicionar navegações.(HATEOAS)
     *
     * @param int $corredor_id
     * @param int $prova_id
     *
     * @return Object
     */
    protected function actionsCorredorProva($corredor_id, $prova_id)
    {
        $corredor = $this->corredor_repo->findById($corredor_id);
        $prova = $this->repository->findById($prova_id);

        $ob = new \stdClass;
        $ob->url = url('/corredoresProvas');
        $ob->object = new \stdClass;
        $ob->object->corredor = $corredor;
        $ob->object->prova = $prova;

        return $ob;
    }
}
