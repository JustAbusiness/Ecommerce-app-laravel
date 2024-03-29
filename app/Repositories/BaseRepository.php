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

    public function pagination(array $column = ['*'], array $condition = [], array $join = [], array $extend = [], int $perpage = 20)
    {
        $query = $this->model->select($column)->where(function($query) use ($condition){
            if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                $query->where('name', 'LIKE', '%'.$condition['keyword'].'%');
            }
            retirn: true;
        });
        if (!empty($join)) {
            $query->join(...$join);
        }
        return $query->paginate($perpage)->withQueryString()->withPath(env('APP_URL').'backend.user.catalogue.index');
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
    public function update( array $payload = [], int $id = 0)
    {
        $model = $this->findById($id);
        return $model->update($payload);
    }

    public function updateByWhereIn(string $whereInField = '', array $whereIn = [], array $payload = [])
    {
        return $this->model->whereIn($whereInField, $whereIn)->update($payload);
    }
    public function delete(int $id = 0)
    {
        $model = $this->findById($id);
        return $model->delete();
    }
    public function forceDelete(int $id=0)
    {
        $model = $this->findById($id);
        return $model->forceDelete();
    }
}
