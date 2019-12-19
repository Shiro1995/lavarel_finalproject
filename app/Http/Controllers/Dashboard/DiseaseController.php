<?php

namespace App\Http\Controllers\Dashboard;

use App\Model\Disease;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Support\Facades\Validator;

class DiseaseController extends Controller
{
    protected $symptom = '';
    protected $mModelDisease;
    use HasTimestamps;

    public function __construct(Disease $diseae) {
        $this->mModelDisease = $diseae;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = $this->mModelDisease->get();
        $collections = collect();
        foreach ($categories as $Disease) {
            $arr = array(
                'id' => $Disease->id,
                'name' => $Disease->name,
                'manipulation' => $Disease->id,
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
            if ($this->mModelDisease->getByName($request->name)) {
                return json_encode(([
                    'message' => [
                        'status' => "invalid",
                        'description' => "The Disease already exists in the system!"
                    ]
                ]));
            } else {
                if ($this->mModelDisease->insert(array([
//                        'id' => 0,
                        'name' => $request->name,
                        'created_at' => $this->freshTimestamp(),
                        'updated_at' => $this->freshTimestamp()
                    ])) > 0) {
                    // Success
                    return json_encode(([
                        'message' => [
                            'status' => "success",
                            'description' => "Create a new Disease successfully"
                        ],
                        'disease' => $this->mModelDisease->getByName($request->name)
                    ]));
                } else {
                    return json_encode(([
                        'message' => [
                            'status' => "error",
                            'description' => "Create a new Disease failure"
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
        public function fetchDisease()
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
                              $this->mModelDisease->insert(array([
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
        $cat = $this->mModelDisease->getSymptons($id);

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
                'disease' => $cat,

            ])

            );
        }
    }
    public function show($id)
    {
        $cat = $this->mModelDisease->getById($id);
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
                'disease' => $cat,
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
            if ($this->mModelDisease->getByName($request->name)) {
                return json_encode(([
                    'message' => [
                        'status' => "invalid",
                        'description' => "The Disease already exists in the system!"
                    ]
                ]));
            } else {
                if ($this->mModelDisease->updateById($id, $request) > 0){
                    return json_encode(([
                        'message' => [
                            'status' => "success",
                            'description' => "Update the Disease success!"
                        ],
                        'disease' => $this->mModelDisease->getById($id)
                    ]));
                }
                else {
                    return json_encode(([
                        'message' => [
                            'status' => "error",
                            'description' => "Update the Disease failure!"
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
        $cat = $this->mModelDisease->deleteById($id);
        //Log::info($id);
        if ( $this->mModelDisease->getById($id) != null) {
            return json_encode(([
                'message' => [
                    'status' => "error",
                    'description' => "Delete the Disease failure",
                ]
            ]));
        } else {
            return json_encode(([
                'message' => [
                    'status' => "success",
                    'description' => "Delete the Disease success "
                ],
                'id' => $id
            ]));
        }
    }

}
