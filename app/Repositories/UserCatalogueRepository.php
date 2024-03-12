<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserCatalogueRepositoryInterface;
use App\Repositories\BaseRepository;


/**
 * Class UserService
 * @package App\Services
 */
class UserCatalogueRepository extends BaseRepository implements UserCatalogueRepositoryInterface
{

    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getAllPaginate()
    {
        return User::paginate(5);
    }


    public function pagination(array $column = ['*'], array $condition = [], array $join = [], array $extend = [], int $perpage = 20)
    {
        $query = $this->model->select($column)->where(function($query) use ($condition){
            if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                $query->where('name', 'LIKE', '%'.$condition['keyword'].'%')
                ->orWhere('email', 'LIKE', '%'.$condition['keyword'].'%')
                ->orWhere('phone', 'LIKE', '%'.$condition['keyword'].'%')
                ->orWhere('address', 'LIKE', '%'.$condition['keyword'].'%')
                ;
            }

            if (isset($condition['publish']) && !empty($condition['publish'])) {
                $query->where('publish', '=', $condition['publish']);
            }

          return $query;
        });
        if (!empty($join)) {
            $query->join(...$join);
        }
        return $query->paginate($perpage)->withQueryString()->withPath(env('APP_URL').'backend.user.catalogue.index');
    }

}
