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
    public function type_disease() {
        $returnHTML = view('ajax.page.disease.type')->render();
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
    public function definitions() {
        $returnHTML = view('ajax.page.definitions.index')->render();
        $response_array = ([
            'success' => true,
            'html' => $returnHTML
        ]);
        echo json_encode($response_array);
    }
    public function prognostics() {
        $returnHTML = view('ajax.page.prognostics.index')->render();
        $response_array = ([
            'success' => true,
            'html' => $returnHTML
        ]);
        echo json_encode($response_array);
    }

    public function reasons() {
        $returnHTML = view('ajax.page.reasons.index')->render();
        $response_array = ([
            'success' => true,
            'html' => $returnHTML
        ]);
        echo json_encode($response_array);
    }
}
