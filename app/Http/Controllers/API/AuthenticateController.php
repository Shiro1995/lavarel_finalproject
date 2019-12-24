<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class AuthenticateController extends Controller
{

    protected $response_array;
    protected $mModelUser;
    protected $database;

    use HasTimestamps;

    public function __construct(User $user)
    {
        $account = ServiceAccount::fromJsonFile(app_path().'/Utilize/Secret/service-account.json');
        $firebase = (new Factory)->withServiceAccount($account)->create();
        $this->database = $firebase->getDatabase();

        $this->mModelUser = $user;
    }

    public function authenticate(Request $request) {
        \Log::info($request);
    }

    public function pharmacy() {

    }
}

