<?php

namespace App\Http\Controllers\API;

use App\Model\Definition;
use App\Model\Prognostic;
use App\Model\Reason;
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
    protected $mReason;
    use HasTimestamps;
    protected $response_array;

    public function __construct(Symptoms $symptoms, Definition $definition, Prognostic $prognostic, Reason $reason) {
        $this->mModelSymptom = $symptoms;
        $this->mPrognostic = $prognostic;
        $this->mDefinition = $definition;
        $this->mReason = $reason;
    }
    public function get_symptoms($disease)
    {
        $symptoms = $this->mModelSymptom->get();
        if($symptoms == null) {
            $this->response_array = ([
                'http_response_code' => http_response_code(),
                'error' => [
                    'code'        => 201,
                    'message'   => "Get a symptom in failure"
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
                    'definitions' => $this->mModelSymptom->getDefinitions($disease),
                    'prognostics' => $this->mModelSymptom->getPrognostics($disease),
                    'reason' => $this->mModelSymptom->getReasons($disease)
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
            for ($i = 0; $i < sizeof($content); $i++) {
//                if ($content[$i] == "Định nghĩa" || $content[$i] == "định nghĩa") {
//                    for ($j = $i + 1; $j < sizeof($content); $j++) {
//                        if ($content[$j] == "Các triệu chứng" || $content[$j] == "các triệu chứng") break;
//                        $definition = array([
//                            'name' => $content[$j],
//                            'disease_id' => $this->id,
//                            'created_at' => $this->freshTimestamp(),
//                            'updated_at' => $this->freshTimestamp()
//                        ]);
//                        $this->mDefinition->insert($definition);
//                    }
//                }
//                if ($content[$i] == "Các triệu chứng" || $content[$i] == "các triệu chứng") {
//                    for ($j = $i + 1; $j < sizeof($content); $j++) {
//                        if ($content[$j] == "Nguyên nhân" || $content[$j] == "nguyên nhân") break;
//                        if ($content[$j] != "Các triệu chứng" || $content[$j] != "các triệu chứng") {
//                            $prognostic = array([
//                                'name' => $content[$j],
//                                'disease_id' => $this->id,
//                                'created_at' => $this->freshTimestamp(),
//                                'updated_at' => $this->freshTimestamp()
//                            ]);
//                            $this->mPrognostic->insert($prognostic);
//                        }
//                    }
//                }
                if ($content[$i] == "Nguyên nhân" || $content[$i] == "nguyên nhân") {
                    for ($j = $i + 1; $j < sizeof($content); $j++) {
                        if ($content[$j] == "Các yếu tố nguy cơ" || $content[$j] == "các yếu tố nguy cơ") break;
                        if ($content[$j] != "Nguyên nhân" || $content[$j] != "nguyên nhân") {
                            $reason = array([
                                'name' => $content[$j],
                                'disease_id' => $this->id,
                                'created_at' => $this->freshTimestamp(),
                                'updated_at' => $this->freshTimestamp()
                            ]);
                            $this->mReason->insert($reason);
                        }
                    }
                }
            }
        });
    }
}
// https://vegibit.com/php-simple-html-dom-parser-vs-friendsofphp-goutte/