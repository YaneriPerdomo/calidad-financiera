<?php

namespace App\Controllers;

use App\Controllers\AuthController;
use App\Models\ProfileModel;

class AccountController extends Controller
{
    public function __construct()
    {

        AuthController::checkSession();
    }

    public function index()
    {

        return $this->view(
            'user.account',
            [
                'sidebar_jump' => './',
                'header_break' => './',
                'header_jump' => './',
                'header_break_login' => '../'
            ]
        );
    }
}
