<?php

namespace App\Http\Controllers\Dashboard;

use App\Model\Pharmacy;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Support\Facades\Validator;

class PharmacyController extends Controller
{
    protected $symptom = '';
    protected $mModelPharmacy;
    use HasTimestamps;

    public function __construct(Pharmacy $pharmacies) {
        $this->mModelPharmacy = $pharmacies;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = $this->mModelPharmacy->get();
        $collections = collect();
        foreach ($categories as $Pharmacy) {
            $arr = array(
                'id' => $Pharmacy->id,
                'name' => $Pharmacy->name,
                'manipulation' => $Pharmacy->id,
            );
            $collections->push($arr);
        }
        return Datatables::collection($collections)->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        \Log::info('hello');
        $credentials = $request->only('name');
        $rules = [
            'name' => 'required'
        ];
        $customMessages = [
            'required' => 'Please fill in form'
        ];

        $validator = Validator::make($credentials, $rules, $customMessages);
        if ($validator->fails()) {
            return json_encode(([
                'message' => [
                    'status' => "invalid",
                    'description' => $validator->errors()->first()
                ]
            ]));
        } else {
            if ($this->mModelPharmacy->getByName($request->name)) {
                return json_encode(([
                    'message' => [
                        'status' => "invalid",
                        'description' => "The Pharmacy already exists in the system!"
                    ]
                ]));
            } else {
                if ($this->mModelPharmacy->insert(array([
//                        'id' => 0,
                        'name' => $request->name,
                        'created_at' => $this->freshTimestamp(),
                        'updated_at' => $this->freshTimestamp()
                    ])) > 0) {
                    // Success
                    return json_encode(([
                        'message' => [
                            'status' => "success",
                            'description' => "Create a new Pharmacy successfully"
                        ],
                        'Pharmacy' => $this->mModelPharmacy->getByName($request->name)
                    ]));
                } else {
                    return json_encode(([
                        'message' => [
                            'status' => "error",
                            'description' => "Create a new Pharmacy failure"
                        ]
                    ]));
                }
            }
        }
    }


    public  function  fetchsymptom(string $name)
    {
        \Log::info('say hi');
        $goutteClient = new \Goutte\Client();
        $guzzleClient = new Client([
            'timeout' => 60,
            'verify' => false,
        ]);
        $goutteClient->setClient($guzzleClient);
        $url2 = "https://hellobacsi.com/benh/".$name;

//        $crawler = $goutteClient->request('GET', $url2);
        \Log::info($url2);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
        public function fetchPharmacy()
        {

            $goutteClient = new \Goutte\Client();
            $guzzleClient = new Client([
                'timeout' => 60,
                'verify' => false,
            ]);
            $goutteClient->setClient($guzzleClient);
            $url = "https://hellobacsi.com/benh/alkapton-nieu/";

            $crawler = $goutteClient->request('GET', $url);

            \Log::info('ehllo');

                  $crawler->filter('section#h-trieu-chung-thuong-gap')->each(function ($node) {
                          $node->filter('p')->each(function ($node1) {


                              \Log::info( $node1->text());
                              $this->mModelPharmacy->insert(array([
//                        'id' => 0,
//                                  'name' => $node2->text(),
                                  'created_at' => $this->freshTimestamp(),
                                  'updated_at' => $this->freshTimestamp()
                              ]));
                          });

                  });




        }
    public function showSymptom($id)
    {
        $cat = $this->mModelPharmacy->getSymptons($id);

        if ($cat == null) {
            return json_encode(([
                'message' => [
                    'status' => "error",
                    'description' => "The customer didn't exist in our system!"
                ]
            ]));
        } else {
            return json_encode(([
                'message' => [
                    'status' => "success",
                    'description' => ""
                ],
                'Pharmacy' => $cat,

            ])

            );
        }
    }
    public function show($id)
    {
        $cat = $this->mModelPharmacy->getById($id);
        if ($cat == null) {
            return json_encode(([
                'message' => [
                    'status' => "error",
                    'description' => "The customer didn't exist in our system!"
                ]
            ]));
        } else {
            return json_encode(([
                'message' => [
                    'status' => "success",
                    'description' => ""
                ],
                'Pharmacy' => $cat,
            ])

            );
        }
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
        $credentials = $request->only('name');
        $rules = [
            'name' => 'required',
        ];
        $customMessages = [
            'required' => 'Please fill in form'
        ];

        $validator = Validator::make($credentials, $rules, $customMessages);
        if ($validator->fails()) {
            return json_encode(([
                'message' => [
                    'status' => "invalid",
                    'description' => $validator->errors()->first()
                ]
            ]));
        } else {
            if ($this->mModelPharmacy->getByName($request->name)) {
                return json_encode(([
                    'message' => [
                        'status' => "invalid",
                        'description' => "The Pharmacy already exists in the system!"
                    ]
                ]));
            } else {
                if ($this->mModelPharmacy->updateById($id, $request) > 0){
                    return json_encode(([
                        'message' => [
                            'status' => "success",
                            'description' => "Update the Pharmacy success!"
                        ],
                        'Pharmacy' => $this->mModelPharmacy->getById($id)
                    ]));
                }
                else {
                    return json_encode(([
                        'message' => [
                            'status' => "error",
                            'description' => "Update the Pharmacy failure!"
                        ]
                    ]));
                }
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function destroy($id)
    {
        $cat = $this->mModelPharmacy->deleteById($id);
        //Log::info($id);
        if ( $this->mModelPharmacy->getById($id) != null) {
            return json_encode(([
                'message' => [
                    'status' => "error",
                    'description' => "Delete the Pharmacy failure",
                ]
            ]));
        } else {
            return json_encode(([
                'message' => [
                    'status' => "success",
                    'description' => "Delete the Pharmacy success "
                ],
                'id' => $id
            ]));
        }
    }

}
