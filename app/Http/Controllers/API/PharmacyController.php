<?php

namespace App\Http\Controllers\API;

use App\Model\Disease;
use App\Model\Pharmacy;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function __construct(Pharmacy $pharmacy) {
        $this->mModelPharmacy = $pharmacy;
    }
    public function getPharmacy()
    {


        $pharmacies = $this->mModelPharmacy->get();
//        $result = array();
//        foreach($typebooks as $typebook) {
//            $result[] = array(
//                'typebook' => $typebook,
//                'books' => $books,
//            );
//        }
        if($pharmacies==null) {
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
                    'diseases' => $pharmacies,
                ]
            ]);
            \Log::info($this->response_array);
        }

        return json_encode($this->response_array);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
