<?php

namespace App\Http\Controllers\API;

use App\Model\Symptoms;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use App\Http\Controllers\Controller;

class SymptomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $symptom = '';
    protected $mModelSymptom;
    use HasTimestamps;
    protected $response_array;

    public function __construct(Symptoms $symptoms) {
        $this->mModelSymptom = $symptoms;
    }
    public function getSymptom()
    {
        $symptoms = $this->mModelSymptom->get();
        if($symptoms==null) {
            $this->response_array = ([
                'http_response_code' => http_response_code(),
                'error' => [
                    'code'        => 201,
                    'message'   => "did't get"
                ],
                'data'  => null,
            ]);
        } else {
            $this->response_array = ([
                'http_response_code' => http_response_code(),
                'error' => [
                    'code'        => 0,
                    'message'   => "Success"
                ],
                'data' => [
                    'diseases' => $symptoms,
                ]
            ]);
        }
        return json_encode($this->response_array);
    }
}
