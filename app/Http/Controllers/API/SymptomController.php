<?php

namespace App\Http\Controllers\API;

use App\Model\Definition;
use App\Model\Prognostic;
use App\Model\Symptoms;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

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
    protected $mPrognostic;
    protected $mDefinition;
    use HasTimestamps;
    protected $response_array;

    public function __construct(Symptoms $symptoms, Definition $definition, Prognostic $prognostic) {
        $this->mModelSymptom = $symptoms;
        $this->mPrognostic = $prognostic;
        $this->mDefinition = $definition;
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
        $crawler->filter('div.detail' )->first()->each(function ($node) {
            $content = $node->filter('p')->eq(10)->siblings()->each(function ($node1) {
                return $node1->text();
            });

            $result = array();
            for ($i = 0; $i < sizeof($content); $i++) {
                if ($content[$i] == "Định nghĩa" || $content[$i] == "định nghĩa") {
                    for ($j = 0; $j < sizeof($content); $j++) {
                        if ($content[$j] == "Các triệu chứng" || $content[$j] == "các triệu chứng") break;
//                        $result[] = array(
//                            'definition' => $content[$j]
//                        );
                        if ($content[$j] != "Định nghĩa" || $content[$i] == "định nghĩa") {
                            $definition = array([
                                'name' => $content[$j],
                                'disease_id' => $this->id,
                                'created_at' => $this->freshTimestamp(),
                                'updated_at' => $this->freshTimestamp()
                            ]);
                            $this->mDefinition->insert($definition);
                        }
                    }
                }
            }
//            $symptom = array([
//                'name' => $name[0],
//                'level' => 1,
//                'parent_id' => $this->id,
//                'is_editable' => 0,
//                'status' => 0,
//                'locate' => 'all',
//                'type' => null,
//                'path' => $path[0],
//                'description' => $description[0],
//                'created_at' => $this->freshTimestamp(),
//                'updated_at' => $this->freshTimestamp()
//            ]);
//            Log::info($content);
            Log::info($result);
//            $this->mModelSymptom->synchWithServerFromLocal($symptom);
        });
    }
}

// https://vegibit.com/php-simple-html-dom-parser-vs-friendsofphp-goutte/