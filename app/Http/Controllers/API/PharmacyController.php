<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Pharmacy;
use App\User;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Http\Request;

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
        $this->mModelPharmacy = $pharmacy;
        $this->mModelUser = $user;
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
                'user' => $this->mModelUser->getById($pharmacy->user_id),
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
                'data' => $result,
            ]);
        }
        return json_encode($this->response_array);
    }

    public function check_pharmacy(Request $request) {
        if ($this->mModelUser->getByUid($request->uid) != null) {
            $pharmacy = $this->mModelPharmacy->getByUserId($this->mModelUser->getByUid($request->uid)->id);
            if ($pharmacy != null) {
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
                    'user' => $this->mModelUser->getById($pharmacy->user_id),
                );
                $this->response_array = ([
                    'http_response_code' => http_response_code(),
                    'error' => [
                        'code' => 0,
                        'message' => "Success"
                    ],
                    'data' => $result,
                ]);
            } else {
                $this->response_array = ([
                    'http_response_code' => http_response_code(),
                    'error' => [
                        'code' => 308,
                        'message' => "Error"
                    ],
                    'data' => null,
                ]);
            }
        } else {
            $this->response_array = ([
                'http_response_code' => http_response_code(),
                'error' => [
                    'code' => 308,
                    'message' => "Error"
                ],
                'data' => null,
            ]);
        }
        return json_encode($this->response_array);
    }
}
