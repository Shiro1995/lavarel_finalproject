<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Pharmacy;
use App\User;
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
    protected $mModelUser;
    use HasTimestamps;
    protected $response_array;

    public function __construct(Pharmacy $pharmacy, User $user)
    {
        $this->mModelUser = $user;
        $this->mModelPharmacy = $pharmacy;
    }

    public function get_pharmacy()
    {
        $pharmacies = $this->mModelPharmacy->get();
        $result = array();
        foreach($pharmacies as $pharmacy) {
            $result[] = array(
                'id' => $pharmacy->id,
                'name' => $pharmacy->name,
                'image' => $pharmacy->image,
                'address' => $pharmacy->address,
                'phone_number' => $pharmacy->phone_number,
                'open_time' => $pharmacy->open_time,
                'close_time' => $pharmacy->close_time,
                'created_at' => $pharmacy->created_at,
                'updated_at' => $pharmacy->updated_at,
                'user' => $this->mModelUser->getByID($pharmacy->user_id)
            );
        }

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
                'data' => $result
            ]);
        }

        return json_encode($this->response_array);
    }
}
