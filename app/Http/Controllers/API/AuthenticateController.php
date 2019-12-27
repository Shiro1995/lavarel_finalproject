<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Http\Request;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Value\Provider;

class AuthenticateController extends Controller
{

    protected $response_array;
    protected $mModelUser;
    protected $database;
    protected $firebase;

    use HasTimestamps;

    public function __construct(User $user)
    {
        $account = ServiceAccount::fromJsonFile(app_path().'/Utilize/Secret/service-account.json');
        $this->firebase = (new Factory)->withServiceAccount($account)->create();

        $this->mModelUser = $user;
    }

    // https://readthedocs.org/projects/firebase-php/downloads/pdf/latest/
    public function authenticate(Request $request) {
        try {
            $provide = $request->provider; // I'm set hard code here, we will get from mobile.
            return $this->firebase->getAuth()->linkProviderThroughAccessToken($provide, $request->access_token);
        } catch (AuthException $e) {
            $this->response_array = ([
                'http_response_code' => http_response_code(),
                'error' => [
                    'code'        => 301,
                    'message'   => $e->getMessage()
                ],
                'data' => null
            ]);
        } catch (FirebaseException $e) {
            $this->response_array = ([
                'http_response_code' => http_response_code(),
                'error' => [
                    'code' => 302,
                    'message' => $e->getMessage()
                ],
                'data' => null
            ]);
        }
        echo json_encode($this->response_array);
    }

    public function pharmacy() {

    }
}

