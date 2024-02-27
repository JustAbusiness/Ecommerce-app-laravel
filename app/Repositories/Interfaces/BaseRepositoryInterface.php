<?php

namespace App\Repositories\Interfaces;


interface BaseRepositoryInterface
{
    public function all();
    public function findById(int $id, array $column = ['*'], array $relation = []);
    public function create(array $payload);
    public function update(array $payload, int $id = 0);
    public function delete(int $id = 0);
    public function forceDelete(int $id = 0);
    public function pagination(array $column = ['*'], array $condition = [], array $join = [], int $perpage = 20);
}
