<?php

namespace App\Repositories\Interfaces;


interface ProvinceRepositoryInterface
{
    public function all();
    public function findById(int $id, array $column = ['*'], array $relation = []);
}
