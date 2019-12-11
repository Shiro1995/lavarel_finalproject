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
    protected $id;

    public function __construct(Disease $diseae) {
        $this->mModelDisease = $diseae;
    }

    public function get_diseases()
    {
        $type_diseases = $this->mModelDisease->get();
        $result = array();
        foreach($type_diseases as $type) {
            $result[] = array(
                'id' => $type->id,
                'name' => $type->name,
                'description' => $type->description,
                'level' => $type->level,
                'parent_id' => $type->parent_id,
                'is_editable' => $type->is_editable,
                'status' => $type->status,
                'locate' => $type->locate,
                'type' => $type->type,
                'path' => $type->path,
                'created_at' => $type->created_at,
                'updated_at' => $type->updated_at,
                'diseases' => $this->mModelDisease->getByIdnLevel($type->id, 1),
            );
        }
        if($type_diseases==null) {
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
                'data' => $result
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
            $path = $node->filter('h2 > a')->each(function ($node1) {
                return $node1->attr('href');
            });
            $description = $node->filter('p')->each(function ($node2) {
                return $node2->text();
            });
            $disease = array([
                'name' => $name[0],
                'level' => 0,
                'parent_id' => null,
                'is_editable' => 0,
                'status' => 0,
                'locate' => 'all',
                'type' => null,
                'path' => $path[0],
                'description' => $description[0],
                'created_at' => $this->freshTimestamp(),
                'updated_at' => $this->freshTimestamp()
            ]);
            $this->mModelDisease->synchWithServerFromLocal($disease);
        });
    }

    public function auto_disease($type_disease) {
        $this->id = $type_disease->id;
        $goutteClient = new \Goutte\Client();
        $guzzleClient = new Client([
            'timeout' => 60,
            'verify' => false,
        ]);
        $goutteClient->setClient($guzzleClient);
        $url = "https://www.dieutri.vn".$type_disease->path;
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
            $disease = array([
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
            $this->mModelDisease->synchWithServerFromLocal($disease);
        });
    }
}
