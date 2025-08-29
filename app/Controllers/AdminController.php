<?php

namespace App\Controllers;

use App\Models\AdminModel;

class AdminController extends Controller
{

   public function __construct()
   {

      AuthController::checkSession([2]);
   }

   public function index()
   {

      $resumen_general = new AdminModel();

      $resumen_general->countUsers();
      $resumen_general->countIndicators();
      return $this->view('admin.welcome', [
         'header_jump' => './',
         'sidebar_jump' => './',
         'header_break' => './',
         'data' => $resumen_general->data,
         'header_break_login' => '../'
      ]);
   }
   public function users($page)
   {
      $show_users = new AdminModel();
      $show_users->ShowUsers($page);
      return $this->view('admin.users', [
         'HTML' => $show_users->HTML,
         'header_jump' => '../',
         'sidebar_jump' => '../',
         'header_break' => '../',
         'header_break_login' => '../../',
         'searchUsers' => false,
         'nameUser' => ''
      ]);
   }

   public function searchUsers($searchUsers, $page)
   {
      $show_users = new AdminModel();
      $show_users->ShowSearchUsers($searchUsers, $page);
      return $this->view('admin.users', [
         'HTML' => $show_users->HTML,
         'header_jump' => '../../',
         'sidebar_jump' => '../../',
         'header_break' => '../../',
         'header_break_login' => '../../../',
         'searchUsers' => true,
         'nameUser' => $searchUsers
      ]);
   }
   

}