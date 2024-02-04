<?php

namespace App\Repositories;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Models\Base;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{

    protected $model;

    public function __construct(Model $model)
    {

        $this->model = $model;

    }


    public function all()
    {
        return $this->model->all();
    }

    public function findById(int $modelId, array $column = ['*'], array $relation = [])
    {
        return $this->model->select($column)->with($relation)->findById($modelId);
    }

    public function create( array $payload = [])
    {
        $model =  $this->model->create($payload);
        return $model->fresh();
    }
}
