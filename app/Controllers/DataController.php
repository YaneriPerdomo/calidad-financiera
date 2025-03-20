<?php

namespace App\Controllers;

use App\Controllers\AuthController;

class DataController extends Controller
{
    public function __construct()
    {

        AuthController::checkSession();
    }

    public function index()
    {

        return $this->view('user.data');
    }
}
