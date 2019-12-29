<?php

namespace App\Http\Controllers\Navigation;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class NavigationController extends Controller {

    public function __construct() {
        // TODO
    }

    /**
     * Ajax, using those methods to navigate to Page in DashBoard screen
     */
    public function dashboard() {
        return view('ajax.page.disease.index');
    }

    public function disease() {
        try {
            $returnHTML = view('ajax.page.disease.index')->render();
            return json_encode($response_array = ([
                'success' => true,
                'html' => $returnHTML
            ]));
        } catch (\Throwable $e) {
            Log::info($e);
        }
        return null;
    }
    public function type_disease() {
        try {
            $returnHTML = view('ajax.page.disease.type')->render();
            return json_encode($response_array = ([
                'success' => true,
                'html' => $returnHTML
            ]));
        } catch (\Throwable $e) {
            Log::info($e);
        }
        return null;
    }

    public function category() {
        try {
            $returnHTML = view('ajax.page.category.index')->render();
            return json_encode($response_array = ([
                'success' => true,
                'html' => $returnHTML
            ]));
        } catch (\Throwable $e) {
            \Log::info($e);
        }
        return null;
    }

    public function definitions() {
        try {
            $returnHTML = view('ajax.page.definitions.index')->render();
            return json_encode($response_array = ([
                'success' => true,
                'html' => $returnHTML
            ]));
        } catch (\Throwable $e) {
            Log::info($e);
        }
        return null;
    }

    public function prognostics() {
        try {
            $returnHTML = view('ajax.page.prognostics.index')->render();
            return json_encode($response_array = ([
                'success' => true,
                'html' => $returnHTML
            ]));
        } catch (\Throwable $e) {
            Log::info($e);
        }
        return null;
    }

    public function reasons() {
        try {
            $returnHTML = view('ajax.page.reasons.index')->render();
            return json_encode($response_array = ([
                'success' => true,
                'html' => $returnHTML
            ]));
        } catch (\Throwable $e) {
            \Log::info($e);
        }
        return null;
    }

    public function visitor() {
        try {
            $returnHTML = view('ajax.page.visitor.index')->render();
            return json_encode($response_array = ([
                'success' => true,
                'html' => $returnHTML
            ]));
        } catch (\Throwable $e) {
            \Log::info($e);
        }
        return null;
    }
}
