<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\DistrictRepositoryInterface as DistrictRepository;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;

class LocationController extends Controller
{
    protected $districtRepository;
    protected $provinceRepository;

    public function __construct(
        DistrictRepository $districtRepository,
        ProvinceRepository $provinceRepository
    )
    {
        $this->districtRepository = $districtRepository;
        $this->provinceRepository = $provinceRepository;
    }

    public function getLocation (Request $request)
    {
        $province_id = $request->input('province_id');

        $provinces = $this->provinceRepository->findById($province_id, ['code', 'name'], ['districts']);
        $district = $provinces->districts->toArray();

        $response  = [
            'html' => $this->renderHml($district)
        ];

        return response()->json($response);
    }
}
