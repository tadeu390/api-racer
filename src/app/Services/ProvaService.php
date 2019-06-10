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
            $model = $this->repository->store($data);

            return [
                'success' => true,
                'message' => 'Prova cadastrada com sucesso.',
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
            $model = $this->repository->findById($data['prova_id']);
            $model->corredores()->attach($data['corredor_id']);

            return [
                'success' => true,
                'message' => 'Corredor inscrito com sucesso na prova.',
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
            throw new Exception('o Id informado para o corredor não existe na base de dados.');
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
            throw new Exception('o Id informado para a prova não existe na base de dados.');
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
            throw new Exception('O corredor informado já se encontra cadastrado nessa prova.');
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
                throw new Exception('O corredor informado já se encontra cadastrado em outra prova que possui a mesma data da prova informada.');
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
                return true;
            }
        }

        return false;
    }
}
