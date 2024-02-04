<?php

namespace App\Repositories\Interfaces;


interface BaseRepositoryInterface
{
    public function all();
    public function findById(int $id, array $column = ['*'], array $relation = []);
    public function create(array $payload);
}
