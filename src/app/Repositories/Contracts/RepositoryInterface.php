<?php

namespace App\Repositories\Contracts;

interface RepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function findWhere($column, $value);
    public function findWhereNull($column);
    public function findWhereFirst($column, $value);
    public function paginate($total_page = 10);
    public function store(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function orderBy($column, $order = 'DESC');
    public function groupBy($column);
}