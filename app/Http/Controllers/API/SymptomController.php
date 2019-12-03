<?php

namespace App\Http\Controllers\API;

use App\Model\Symptoms;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use App\Http\Controllers\Controller;

class SymptomController extends Controller
{

    protected $id;
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

    public function auto_symptom($disease) {
        $this->id = $disease->id;
        $goutteClient = new \Goutte\Client();
        $guzzleClient = new Client([
            'timeout' => 60,
            'verify' => false,
        ]);
        $goutteClient->setClient($guzzleClient);
        $url = "https://www.dieutri.vn".$disease->path;
        $crawler = $goutteClient->request('GET', $url);
        $crawler->filter('ul#listGrid > li' )->each(function ($node) {
            $name = $node->filter('h2 > a')->each(function ($node1) {
                return $node1->text();
            });
            $path = $node->filter('h2 > a')->each(function ($node1) {
                return $node1->attr('href');
            });
            $description = $node->filter('p')->each(function ($node2) {
                return $node2->text();
            });
            $symptom = array([
                'name' => $name[0],
                'level' => 1,
                'parent_id' => $this->id,
                'is_editable' => 0,
                'status' => 0,
                'locate' => 'all',
                'type' => null,
                'path' => $path[0],
                'description' => $description[0],
                'created_at' => $this->freshTimestamp(),
                'updated_at' => $this->freshTimestamp()
            ]);
            $this->mModelSymptom->synchWithServerFromLocal($symptom);
        });
    }
}
