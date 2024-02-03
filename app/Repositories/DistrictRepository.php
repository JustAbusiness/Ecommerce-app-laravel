<?php

namespace App\Repositories;

use App\Models\District;
use App\Repositories\Interfaces\DistrictRepositoryInterface;
use App\Repositories\BaseRepository;


/**
 * Class UserService
 * @package App\Services
 */
class DistrictRepository extends BaseRepository implements DistrictRepositoryInterface
{
    protected $model;

    public function __construct(District $model)
    {
        $this->model = $model;
    }

   public function all()
   {
        return $this->model->all();
   }

   public function findDistrictByProvinceId(int $province_id)
   {
        return $this->model->where('province_id', '=',$province_id)->get();
   }
}
