<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Pharmacy;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $symptom = '';
    protected $mModelPharmacy;
    use HasTimestamps;
    protected $response_array;

    public function __construct(Pharmacy $pharmacy)
    {
        $this->mModelPharmacy = $pharmacy;
    }

    public function get_pharmacy()
    {
        $pharmacies = $this->mModelPharmacy->get();

        if ($pharmacies == null) {
            $this->response_array = ([
                'http_response_code' => http_response_code(),
                'error' => [
                    'code' => 201,
                    'message' => "did't get"
                ],
                'data' => null,
            ]);
        } else {
            $this->response_array = ([
                'http_response_code' => http_response_code(),
                'error' => [
                    'code' => 0,
                    'message' => "Success"
                ],
                'data' => [
                    'pharmacies' => $pharmacies,
                ]
            ]);
        }

        return json_encode($this->response_array);
    }
}
