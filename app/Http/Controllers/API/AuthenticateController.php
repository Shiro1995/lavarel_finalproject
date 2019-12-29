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
use Illuminate\Support\Facades\Hash;

class AuthenticateController extends Controller
{

    protected $response_array;
    protected $mModelUser;
    protected $database;
    protected $firebase;

    use HasTimestamps;

    public function __construct(User $user) {
        $account = ServiceAccount::fromJsonFile(app_path().'/Utilize/Secret/service-account.json');
        $this->firebase = (new Factory)->withServiceAccount($account)->create();
        $this->mModelUser = $user;
    }

    // https://readthedocs.org/projects/firebase-php/downloads/pdf/latest/
    public function authenticate(Request $request) {
        try {
            $userInfo = $this->firebase->getAuth()->linkProviderThroughAccessToken($request->provider, $request->access_token);
            $user = $this->mModelUser->getByEmail($userInfo->userRecord->email);
            if ($this->mModelUser->getByEmail($userInfo->userRecord->email) == null && $this->mModelUser->add(array([
                    'id' => self::resetOrderInDB(),
                    'name' => $userInfo->userRecord->displayName,
                    'email' => $userInfo->userRecord->email,
                    'password' => $userInfo->userRecord->passwordHash == null ? Hash::make(str_random(8)) : $userInfo->userRecord->passwordHash,
                    'date_of_birth' => null,
                    'gender' => null,
                    'phone_number' => $userInfo->userRecord->phoneNumber,
                    'avatar' => $userInfo->userRecord->photoUrl,
                    'address' => null,
                    'is_verified' => $userInfo->userRecord->emailVerified ? 1 : 0,
                    'uid' => $userInfo->userRecord->uid,
                    'created_at' => $this->freshTimestamp(),
                    'updated_at' => $this->freshTimestamp(),
                ])) > 0) {
                $this->response_array = ([
                    'http_response_code' => http_response_code(),
                    'error' => [
                        'code'        => 0,
                        'message'   => 'Success'
                    ],
                    'data' => $this->mModelUser->getByEmail($userInfo->userRecord->email)
                ]);
            } else if ($this->mModelUser->updateItem(array([
                    'id' => $user->id,
                    'name' => $userInfo->userRecord->displayName,
                    'email' => $user->email,
                    'password' => $user->password,
                    'date_of_birth' => $user->date_of_birth,
                    'gender' => $user->gender,
                    'avatar' => $userInfo->userRecord->photoUrl,
                    'phone_number' => $userInfo->userRecord->phoneNumber,
                    'address' => $user->address,
                    'is_verified' => $userInfo->userRecord->emailVerified ? 1 : 0,
                    'uid' => $userInfo->userRecord->uid,
                    'remember_token' => $user->remember_token,
                    'created_at' => $this->freshTimestamp(),
                    'updated_at' => $this->freshTimestamp()
                ])) > 0) {
                $this->response_array = ([
                    'http_response_code' => http_response_code(),
                    'error' => [
                        'code'        => 0,
                        'message'   => 'Success'
                    ],
                    'data' => $this->mModelUser->getByEmail($userInfo->userRecord->email)
                ]);
            }
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

    /**
     * Order ID in User table
     * @return int
     */
    public function resetOrderInDB() {
        $i = 1;
        while (true){
            if ($this->mModelUser->getById($i) == null) break;
            $i++;
        }
        return $i;
    }
}

