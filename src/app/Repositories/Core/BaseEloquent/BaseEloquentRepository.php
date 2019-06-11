<?php

namespace App\Repositories\Core\BaseEloquent;

use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Exceptions\NotEntityDefined;

/**
 * Classe responsável pelos métodos a serem utilizados pela aplicação para manipular dados do banco.
*/
class BaseEloquentRepository implements RepositoryInterface
{
    /**
     * Contém a model.
     */
    protected $entity;

    /**
     * Coluna com valor núlo para consultas.
     */
    protected $column_null = null;

    public function __construct()
    {
        $this->entity = $this->resolveEntity();
    }

    /**
     * Retorna todos os registros de um modelo.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->entity->get();
    }

    /**
     * Encontra um registro conforme o id.
     *
     * @param int $id
     *
     * @return array
     */
    public function findById($id)
    {
        return $this->entity->find($id);
    }

    /**
     * Encontra uma lista de registro conforme a coluna e valor informados.
     *
     * @param string $column
     * @param string $value
     *
     * @return array
     */
    public function findWhere($column, $value)
    {
        $this->entity->where($column, $value);

        return $this;
    }

    /**
     * Retorna os resultados da consulta.
     *
     * @return array
     */
    public function get()
    {
        return $this->entity->get();
    }

    /**
     * Específica um campo que contém valores núlos para serem utilizados em uma consulta.
     *
     * @param string $column
     *
     * @return array
     */
    public function findWhereNull($column)
    {
        $this->column_null = $column;

        return $this;
    }

    /**
     * Retorna o primeiro registro encontrado.
     *
     * @param string $column
     * @param string $value
     *
     * @return array
     */
    public function findWhereFirst($column, $value)
    {
        return $this->entity->where($column, $value)->first();
    }

    /**
     * Faz a paginação dos resultados.
     *
     * @param int $totalPage
     *
     * @return array
     */
    public function paginate($total_page = 10)
    {
        return $this->entity->where(function($query) {
            $query->get();
            if ($this->column_null != null) {
                $query->whereNull($this->column_null);
            }
        })->paginate($total_page);
    }

    /**
     * Insere no banco de dados um registro de um determinado modelo.
     *
     * @param array $data
     *
     * @return array
     */
    public function store(array $data)
    {
        return $this->entity->create($data);
    }

    /**
     * Atualiza um determinado registro de um determinado modelo.
     *
     * @param int $id
     * @param array $data
     *
     * @return array
     */
    public function update($id, array $data)
    {
        $entity = $this->findById($id);

        return $entity->update($data);
    }

    /**
     * Apaga um registro de um determinado modelo.
     *
     * @param int $id
     *
     * @return int
     */
    public function delete($id)
    {
        return $this->entity->find($id)->delete();
    }

    /**
     * Permite passar todos os relacionamentos de um modelo para serem carregado juntos.
     *
     * @param string $relationships
     *
     * @return mixed
     */
    public function relationships(...$relationships)
    {
        $this->entity = $this->entity->with($relationships);

        return $this;
    }

    /**
     * Ordena os resultados.
     *
     * @param string $column
     * @param string $order
     *
     * @return mixed
     */
    public function orderBy($column, $order = 'DESC')
    {
        $this->entity = $this->entity->orderBy($column, $order);

        return $this;
    }

    /**
     * Agrupa os resultados.
     *
     * @param string $column
     *
     * @return mixed
     */
    public function groupBy($column)
    {
        $this->entity = $this->entity->groupBy($column);

        return $this;
    }

    /**
     * Verifica se o método entity for criado no modelo que extende dessa classe.
     *
     * @return mixed
     */
    public function resolveEntity()
    {
        if (!method_exists($this, 'entity')) {
            throw new NotEntityDefined;
        }

        return app()->make($this->entity());
    }
}
