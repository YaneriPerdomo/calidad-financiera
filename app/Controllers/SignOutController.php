<?php

namespace App\Controllers;

class SignOutController{
    public function signOut()
    {
        echo 'Yaneri Perdomo';
        session_start();
        session_unset();
        session_destroy();
        header("location: ./login");
        exit();
    }
}
