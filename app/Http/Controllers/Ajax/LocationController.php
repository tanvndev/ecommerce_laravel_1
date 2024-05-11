<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use App\Repositories\Interfaces\DistrictRepositoryInterface as DistrictRepository;
use Illuminate\Http\Request;


class LocationController extends Controller
{
    protected $provinceRepository;
    protected $districtRepository;
    public function __construct()
    {
        parent::__construct();
        $this->districtRepository = app(DistrictRepository::class);
        $this->provinceRepository = app(ProvinceRepository::class);
    }
    function getLocation(Request $request)
    {
        // Lấy ra location id của tỉnh hoặc huyện
        $locationId = $request->data['location_id'];
        // Nhận ra vị trí loction của districts hoặc wards
        $target = $request->target;

        if ($target == 'districts') {
            // Lấy ra data locations districts
            $dataLocations = $this->provinceRepository->findById($locationId, ['code', 'name'], ['districts']);
            $districts = $dataLocations->districts;
            $response = $this->renderHtml($districts);
        } elseif ($target == 'wards') {
            // Lấy ra data locations 
            $dataLocations = $this->districtRepository->findById($locationId, ['code', 'name'], ['wards']);
            $wards = $dataLocations->wards;
            $response = $this->renderHtml($wards, '[Phường/Xã]');
        }

        return response()->json($response);
    }

    private function renderHtml($districts, $target = '[Quận/Huyện]')
    {
        $htmls = '<option>' . $target . '</option>';
        foreach ($districts as $district) {
            $htmls .= '<option value="' . $district->code . '">' . $district->name . '</option>';
        }
        return $htmls;
    }
}
