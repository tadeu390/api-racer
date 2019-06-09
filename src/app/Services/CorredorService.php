<?php
namespace App\Services;

use App\Repositories\Contracts\CorredorRepositoryInterface;
use Carbon\Carbon;

class CorredorService
{
    /**
     * @var CorredorRepositoryInterface
     */
    protected $repository;

    /**
     * Responsável por injetar as dependências necessárias.
     */
    public function __construct(CorredorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Responsável por cadastrar um novo corredor.
     *
     * @param mixed $data
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
                'message' => 'Corredor cadastrado com sucesso.',
                'data'    => $model,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro de execução',
                'data'    => $e->getMessage(),
            ];
        }
    }

    /**
     * Responsável por chamar todos os métodos que aplicam as regras de negócio.
     *
     * @param mixed $data
     */
    protected function validaRegras(array $data)
    {
        $this->validaIdadeMinima($data['data_nascimento']);
    }

    /**
     * Responsável por verificar se o corredor é menor de idade ou não.
     *
     * @param string $data_nascimento
     */
    protected function validaIdadeMinima($data_nascimento)
    {
        try {
            $data = Carbon::createFromFormat('d/m/Y', $data_nascimento);
        } catch (\Exception $e) {
            try {
                $data = Carbon::createFromFormat('Y-m-d', $data_nascimento);
            } catch (\Exception $e) {
                throw new \Exception('O formato da data deve ser d/m/Y ou Y-m-d.');
            }
        }

        $idade = Carbon::now()->diff(new Carbon($data))->y >= 18;

        if (!$idade) {
            throw new \Exception('O corredor deve ter pelo menos 18 anos.');
        }
    }
}
