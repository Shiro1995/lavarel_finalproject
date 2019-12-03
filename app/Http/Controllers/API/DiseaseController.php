<?php

namespace App\Http\Controllers\API;

use App\Model\Disease;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use App\Http\Controllers\Controller;

class DiseaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $symptom = '';
    protected $mModelDisease;
    use HasTimestamps;
    protected $response_array;

    public function __construct(Disease $diseae) {
        $this->mModelDisease = $diseae;
    }

    public function get_diseases()
    {
        $diseases = $this->mModelDisease->get();
        if($diseases==null) {
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
                'data' => $diseases
            ]);
        }

        return json_encode($this->response_array);
    }

    public function auto_type_disease() {
        $goutteClient = new \Goutte\Client();
        $guzzleClient = new Client([
            'timeout' => 60,
            'verify' => false,
        ]);
        $goutteClient->setClient($guzzleClient);
        $url = "https://www.dieutri.vn/benhly";
        $crawler = $goutteClient->request('GET', $url);
        $crawler->filter('ul#listGrid > li' )->each(function ($node) {
            $name = $node->filter('h2 > a')->each(function ($node1) {
               return $node1->text();
            });
            $description = $node->filter('p')->each(function ($node2) {
                return $node2->text();
            });
            $disease = array([
                'name' => $name[0],
                'description' => $description[0],
                'created_at' => $this->freshTimestamp(),
                'updated_at' => $this->freshTimestamp()
            ]);
            $this->mModelDisease->synchWithServerFromLocal($disease);
        });
    }
}
