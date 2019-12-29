<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of your object.
     * For example: You want to get list of books. This controller should be called BookController.php
     * And then in method @index. You will load all books here.
     * You should do some steps below:
     * - Prepare view(blade php) from view folder
     * - Using method ->with() or ->compact() to pass your list, object to view
     * - Return it.
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('index');
    }
}
