<?php

namespace App\Http\Controllers\Navigation;

use App\Http\Controllers\Controller;

class NavigationController extends Controller
{

    public function __construct() {
    }

    /**
     * Ajax, using those methods to navigate to Page in DashBoard screen
     */
    public function dashboard() {
        return view('ajax.page.disease.index');
    }

    public function disease() {
        $returnHTML = view('ajax.page.disease.index')->render();
        $response_array = ([
            'success' => true,
            'html' => $returnHTML
        ]);
        echo json_encode($response_array);
    }

    public function category() {
        $returnHTML = view('ajax.page.category.index')->render();
        $response_array = ([
            'success' => true,
            'html' => $returnHTML
        ]);
        echo json_encode($response_array);
    }
    public function symptom() {
        $returnHTML = view('ajax.page.symptom.index')->render();
        $response_array = ([
            'success' => true,
            'html' => $returnHTML
        ]);
        echo json_encode($response_array);
    }

}
