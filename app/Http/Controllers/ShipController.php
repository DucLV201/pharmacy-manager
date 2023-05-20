<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

use App\Models\Province;
use App\Models\District;
use App\Models\Ward;



class ShipController extends Controller
{
    public function test(){
        
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Token' => 'ce83ded6-f55f-11ed-a967-deea53ba3605',
            'ShopId' => '4148300',
        ])
            ->post('https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee', [
                'from_district_id' => 1447,
                'service_id' => 55319,
                'service_type_id' => null,
                'to_district_id' => 1442,
                'to_ward_code' => '21012',
                'height' => 50,
                'length' => 20,
                'weight' => 200,
                'width' => 20,
                'cod_failed_amount' => 2000,
                'insurance_value' => 10000,
                'coupon' => null
            ]);
        
        $data = $response->json();
        dd($data);  
    }
    
    public function test1(){
        for ($i = 3600; $i <= 3700; $i++) {

        $response = Http::withHeaders([
            'Token' => 'ce83ded6-f55f-11ed-a967-deea53ba3605',
            'Content-Type' => 'application/json'
        ])->get('https://online-gateway.ghn.vn/shiip/public-api/master-data/ward', [
            'district_id' => $i
        ]);
        
        $data = json_decode($response->body(), true);

        if ($data && isset($data['data'])) {
            foreach ($data['data'] as $item) {
                // Lưu thông tin cần thiết vào cơ sở dữ liệu
                $ward = new Ward;
                $ward->id = intval($item['WardCode']);
                $ward->name = $item['WardName'];
                $ward->district_id = $item['DistrictID'];
                $ward->save();
            }
        }
        usleep(500000);
        echo $i;

        }
    }

    public function index()
    {
        $provinces = Province::all();
        return view('user.test1',['provinces' => $provinces]);
    }
    public function province($provinceId) {
        $districts = District::where('province_id', $provinceId)->get();
        return response()->json($districts);
    }
    public function district($districtId) {
        $wards = Ward::where('district_id', $districtId)->get();
        return response()->json($wards);
    }



    // public function addProvince(){
        
    //     $response = Http::withHeaders([
    //         'Token' => 'ce83ded6-f55f-11ed-a967-deea53ba3605',
    //         'Content-Type' => 'application/json'
    //     ])->get('https://online-gateway.ghn.vn/shiip/public-api/master-data/province');
        
    //     $data = json_decode($response->body(), true);

    //     if ($data && isset($data['data'])) {
    //         foreach ($data['data'] as $item) {
    //             // Lưu thông tin cần thiết vào cơ sở dữ liệu
    //             $province = new Province;
    //             $province->id = $item['ProvinceID'];
    //             $province->name = $item['ProvinceName'];
    //             $province->CountryID = $item['CountryID'];
    //             $province->save();
    //         }
    //     }
    //     echo 'xong';
    // }

    // public function addDistrict(){
        
    //     $response = Http::withHeaders([
    //         'Token' => 'ce83ded6-f55f-11ed-a967-deea53ba3605',
    //         'Content-Type' => 'application/json'
    //     ])->get('https://online-gateway.ghn.vn/shiip/public-api/master-data/district');
        
    //     $data = json_decode($response->body(), true);

    //     if ($data && isset($data['data'])) {
    //         foreach ($data['data'] as $item) {
    //             // Lưu thông tin cần thiết vào cơ sở dữ liệu
    //             $district = new District;
    //             $district->id = $item['DistrictID'];
    //             $district->name = $item['DistrictName'];
    //             $district->province_id = $item['ProvinceID'];
    //             $district->save();
    //         }
    //     }
    //     echo 'xong';
    // }
}
