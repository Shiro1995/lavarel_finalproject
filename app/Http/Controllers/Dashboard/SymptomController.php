<?php

namespace App\Http\Controllers\Dashboard;

use App\Model\Disease;
use App\Model\Symptoms;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Support\Facades\Validator;

class SymptomController extends Controller
{

    protected $mModelCat;
    use HasTimestamps;

    public function __construct(Symptoms $cat) {
        $this->middleware('auth');
        $this->mModelCat = $cat;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = $this->mModelCat->get();
        $collections = collect();
        foreach ($categories as $symptom) {
            $arr = array(
                'id' => $symptom->id,
                'name' => $symptom->name,
                'manipulation' => $symptom->id
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
        \Log::info('chao ban');
    }
    protected function print()
    {
        \Log::info('hhihihihdsfsadf1');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $credentials = $request->only('symptom_name');
        $rules = [
            'symptom_name' => 'required'
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
            if ($this->mModelCat->getByName($request->symptom_name)) {
                return json_encode(([
                    'message' => [
                        'status' => "invalid",
                        'description' => "The symptom already exists in the system!"
                    ]
                ]));
            } else {
                if ($this->mModelCat->insert(array([
//                        'id' => 0,
                        'name' => $request->symptom_name,
                        'created_at' => $this->freshTimestamp(),
                        'updated_at' => $this->freshTimestamp()
                    ])) > 0) {


                    // Success
                    return json_encode(([
                        'message' => [
                            'status' => "success",
                            'description' => "Create a new Symptom successfully"
                        ],
                        'symptom' => $this->mModelCat->getByName($request->symptom_name),
                    ]));
                } else {
                    return json_encode(([
                        'message' => [
                            'status' => "error",
                            'description' => "Create a new Symptom failure"
                        ]
                    ]));
                }
            }
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function testadd()
    {
        $this->mModelCat->getByName('')->id;
    }
    public function addSymptom(Request $request,$id)
    {

        $credentials = $request->only('symptom_name');

        $rules = [
            'symptom_name' => 'required'
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
            if ($this->mModelCat->getByName($request->symptom_name)) {
                return json_encode(([
                    'message' => [
                        'status' => "invalid",
                        'description' => "The symptom already exists in the system!"
                    ]
                ]));
            } else {
                if ($this->mModelCat->insert(array([
//                        'id' => 0,
                        'name' => $request->symptom_name,
                        'created_at' => $this->freshTimestamp(),
                        'updated_at' => $this->freshTimestamp()
                    ])) > 0) {
                    \Log::info($this->mModelCat->getByName($request->symptom_name)->id);
                    // Success
                    if($this->mModelCat->addSym(array([
                            'disease_id' => $id,
                            'symptom_id' => $this->mModelCat->getByName($request->symptom_name)->id
                        ]))>0){
                    return json_encode(([
                        'message' => [
                            'status' => "success",
                            'description' => "Create a new Symptom successfully"
                        ],
                        'symptom' => $this->mModelCat->getByName($request->symptom_name),

//                        $this->mModelCat->insert(array([
//                                'disease_id' => $id,
//                                'symptom_id' => $this->mModelCat->getByName($request->symptom_name)['id']
//                        ]))
                    ]));
                }else {
                    return json_encode(([
                        'message' => [
                            'status' => "error",
                            'description' => "Create a new Symptom failure"
                        ]
                    ]));
                }
            }}
        }
    }

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


        $crawler->filter('section#h-trieu-chung-thuong-gap')->each(function ($node) {
            $node->filter('p')->each(function ($node1) {
                if($this->mModelCat->getByName($node1->text()))
                { return null;}
                else{
                    \Log::info($node1->text());
                    $this->mModelCat->insert(array([
//                        'id' => 0,
                        'name' => $node1->text(),
                        'created_at' => $this->freshTimestamp(),
                        'updated_at' => $this->freshTimestamp()
                    ]));
                    $this->mModelCat->addSym(array([
                        'disease_id' => 16,
                        'symptom_id' => $this->mModelCat->getByName($node1->text())->id
                    ]));
                }
            });
            $node->filter('li')->each(function ($node2) {
//                \Log::info($this->mModelCat->getByName($node2->text()));
                if($this->mModelCat->getByName($node2->text()))
                {return null;}
                else{

                    $this->mModelCat->insert(array([
//                        'id' => 0,
                        'name' => $node2->text(),
                        'created_at' => $this->freshTimestamp(),
                        'updated_at' => $this->freshTimestamp()
                    ]));
                    $this->mModelCat->addSym(array([
                        'disease_id' => 16,
                        'symptom_id' => $this->mModelCat->getByName($node2->text())->id
                    ]));

                }
            });


        });
    }
    public function show($id)
    {
        $cat = $this->mModelCat->getById($id);
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
                'symptom' => $cat,
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
            if ($this->mModelCat->getByName($request->name)) {
                return json_encode(([
                    'message' => [
                        'status' => "invalid",
                        'description' => "The symptom already exists in the system!"
                    ]
                ]));
            } else {
                if ($this->mModelCat->updateById($id, $request) > 0){
                    return json_encode(([
                        'message' => [
                            'status' => "success",
                            'description' => "Update the Symptom success!"
                        ],
                        'symptom' => $this->mModelCat->getById($id)
                    ]));
                }
                else {
                    return json_encode(([
                        'message' => [
                            'status' => "error",
                            'description' => "Update the symptom failure!"
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

    public function test()
    {

    }
    public function destroy($id)
    {
        $cat = $this->mModelCat->deleteById($id);
        //Log::info($id);
        if ( $this->mModelCat->getById($id) != null) {
            return json_encode(([
                'message' => [
                    'status' => "error",
                    'description' => "Delete the symptom failure",
                ]
            ]));
        } else {
            return json_encode(([
                'message' => [
                    'status' => "success",
                    'description' => "Delete the symptom success "
                ],
                'id' => $id
            ]));
        }
    }
}
