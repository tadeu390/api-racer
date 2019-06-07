<?php
namespace App\Repositories\Core\BaseEloquent;

use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Exceptions\NotEntityDefined;

class BaseEloquentRepository implements RepositoryInterface
{
    protected $entity;
    protected $column_null = null;

    public function __construct()
    {
        $this->entity = $this->resolveEntity();
    }

    public function getAll()
    {
        return $this->entity->get();
    }

    public function findById($id)
    {
        return $this->entity->find($id);
    }

    public function findWhere($column, $value)
    {
        $this->entity->where($column, $value)->get();

        return $this;
    }

    public function findWhereNull($column)
    {
        $this->column_null = $column;

        return $this;
    }

    public function findWhereFirst($column, $value)
    {
        return $this->entity->where($column, $value)->first();
    }

    public function paginate($totalPage = 10)
    {
        return $this->entity->where(function($query) {
            $query->get();
            if ($this->column_null != null) {
                $query->whereNull($this->column_null);
            }
        })->paginate($totalPage);
    }

    public function store(array $data)
    {
        return $this->entity->create($data);
    }

    public function update($id, array $data)
    {
        $entity = $this->findById($id);

        return $entity->update($data);
    }

    public function delete($id)
    {
        return $this->entity->find($id)->delete();
    }

    public function relationships(...$relationships)
    {
        $this->entity = $this->entity->with($relationships);

        return $this;
    }

    public function orderBy($column, $order = 'DESC')
    {
        $this->entity = $this->entity->orderBy($column, $order);
        return $this;
    }

    public function groupBy($column)
    {
        $this->entity = $this->entity->groupBy($column);
        return $this;
    }

    public function resolveEntity()
    {
        if (!method_exists($this, 'entity')) {
            throw new NotEntityDefined;
        }

        return app()->make($this->entity());
    }
}
