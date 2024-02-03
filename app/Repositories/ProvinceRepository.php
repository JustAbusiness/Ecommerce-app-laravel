<?php

namespace App\Repositories;

use App\Models\Province;
use App\Models\User;
use App\Repositories\Interfaces\ProvinceRepositoryInterface;
use App\Repositories\BaseRepository;


class ProvinceRepository extends BaseRepository implements ProvinceRepositoryInterface
{
    protected $model;

    public function __construct( Province $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return Province::all();
    }
}
