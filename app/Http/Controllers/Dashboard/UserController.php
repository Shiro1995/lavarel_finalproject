<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Support\Facades\Validator;
use Storage;
use Config;

class UserController extends Controller
{

    protected $mModelUser;
    use HasTimestamps;

    public function __construct(User $user) {
        $this->mModelUser = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $users = $this->mModelUser->get();
        $collections = collect();
        foreach ($users as $user) {
            if (DB::table('model_has_roles')->where('role_id', $user->id)->where('model_id', 3)->first() != null) {
                $arr = array(
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'date_of_birth' => $user->date_of_birth == null ? null : date("M d, Y", $user->date_of_birth),
                    'avatar' => $user->avatar,
                    'phone_number' => $user->phone_number,
                    'address' => $user->address,
                    'gender' => $user->gender,
                    'manipulation' => $user->id
                );
                $collections->push($arr);
            }
        }
        return Datatables::collection($collections)->make();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $credentials = $request->only('name', 'email', 'password');
        $rules = [
            'name' => 'required', 'string', 'max:255',
            'email' => 'required','string', 'email', 'max:255', 'unique:users',
            'password' => 'required'
        ];
        $customMessages = [
            'required' => 'The attribute field is required',
            'email' => 'The email address is invalid',
            'max:255' => 'The max of the length of content is limited by 255 characters.',
            'unique:users' => 'The email address have already existed in the system',
        ];
        $request->avatar = '';
        if (isset($_FILES['avatar']['tmp_name'])) {
            if (!file_exists($_FILES['avatar']['tmp_name']) || !is_uploaded_file($_FILES['avatar']['tmp_name'])) {
                $request->avatar = 'https://vogobook.s3-ap-southeast-1.amazonaws.com/vogobook/avatar/data/profile.png';
            } else {
                $fileExt = $request->file('avatar')->getClientOriginalName();
                $fileName = pathinfo($fileExt, PATHINFO_FILENAME);
                $info = pathinfo($_FILES['avatar']['name']);
                if (preg_match("/^.*picture.*$/", $info['filename']) == 0) {
                    $ext = $info['extension'];
                } else {
                    $ext = 'png';
                }
                $key = $this->helper->clean(trim(strtolower($fileName)) . "_" . time()) . "." . $ext;
                Storage::disk('s3')->put(Config::get('constants.options.ezhealthcare') . '/' . $key, fopen($request->file('avatar'), 'r+'), 'public');
                $request->avatar = preg_replace("/^http:/i", "https:", Storage::disk('s3')->url(Config::get('constants.options.ezhealthcare') . '/' . $key));
            }
        }
        $validator = Validator::make($credentials, $rules, $customMessages);
        if ($validator->fails()) {
            $this->response_array = ([
                'message' => [
                    'status' => 'invalid',
                    'description' => $validator->errors()->first()
                ]
            ]);
        } else {
            if ($this->mModelUser->getByEmail($request->email)) {
                $this->response_array = ([
                    'message' => [
                        'status' => 'invalid',
                        'description' => 'The email already exists in the system!'
                    ]
                ]);
            } else {
                if ($this->mModelUser->add(array([
                        'id' => self::resetOrderInDB(),
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'date_of_birth' => strtotime($request->date_of_birth),
                        'gender' => $request->gender,
                        'phone_number' => $request->phone_number,
                        'avatar' => $request->avatar,
                        'address' => $request->address,
                        'created_at' => $this->freshTimestamp(),
                        'updated_at' => $this->freshTimestamp(),
                    ])) > 0) {
                    $this->response_array = ([
                        'message' => [
                            'status' => 'success',
                            'description' => 'Create a new customer successfully'
                        ],
                        'user' => $this->mModelUser->getByEmail($request->email)
                    ]);
                } else {
                    $this->response_array = ([
                        'message' => [
                            'status' => 'error',
                            'description' => 'Create a new customer in failure'
                        ]
                    ]);
                }
            }
        }
        echo json_encode($this->response_array);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
                'categories' => $cat
            ]));
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
                        'description' => "The category already exists in the system!"
                    ]
                ]));
            } else {
                if ($this->mModelCat->updateById($id, $request) > 0){
                    return json_encode(([
                        'message' => [
                            'status' => "success",
                            'description' => "Update the category success!"
                        ],
                        'category' => $this->mModelCat->getById($id)
                    ]));
                }
                else {
                    return json_encode(([
                        'message' => [
                            'status' => "error",
                            'description' => "Update the category failure!"
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
        $cat = $this->mModelCat->deleteById($id);
        //Log::info($id);
        if ( $this->mModelCat->getById($id) != null) {
            return json_encode(([
                'message' => [
                    'status' => "error",
                    'description' => "Delete the category failure",
                ]
            ]));
        } else {
            return json_encode(([
                'message' => [
                    'status' => "success",
                    'description' => "Delete the category success "
                ],
                'id' => $id
            ]));
        }
    }
}