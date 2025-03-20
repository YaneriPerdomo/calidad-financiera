<?php

namespace App\Controllers;

use App\Controllers\AuthController;
use App\Models\GuestModel;

class GuestsController extends Controller
{
   public function __construct()
   {

      AuthController::checkSession();
   }

   // Mostrar la vista principal del modulo invitados
   public function index()
   {
      return $this->view('user.guests');
   }

   // Mostrar la vista para que el usuario pueda agregar un invitado
   public function showAddForm()
   {

      return $this->view('user.guest');
   }


   public function OperationData()
   {
      if ($_POST['operation'] == 'update') {
         return $this->UpdateData();
      } else {
         return $this->AddData();
      }
   }

   public function UpdateData()
   {

      if (empty($_POST)) {
         echo '<script>alert("No se han recibido datos para agregar")
         location.href = "./guest"
         </script>';
      }
 
      $add_data_guest = new GuestModel();
      $add_data_guest->UpdateData([
         'id_user' => $_POST['id_user'],
         'id_person' => $_POST['id_person'],
         'user' => $_POST['user'],
         'name' => $_POST['name'],
         'lastname' => $_POST['lastname'],
         'email' => $_POST['email'] ?? NULL,
         'password' => $_POST['password'] ?? ''
      ]);

      echo $add_data_guest->data;

      return ($add_data_guest->status == 1)
      ? '<script>alert("Error al agregar registro"); location.href = "./guest"</script>'
      : '<script>alert("Datos registrados correctamente"); location.href = "./guests"</script>';
   }

   public function showData($id)
   {

      $get_data_guest = new GuestModel();
      $get_data_guest->showData($id);
      return $this->view('user.guest', ['data' => $get_data_guest->data]);
   }
   public function AddData()
   {
      if (empty($_POST)) {
         echo '<script>alert("No se han recibido datos para agregar")
         location.href = "./add-guest"
         </script>';
      }
      $add_data_guest = new GuestModel();
      $add_data_guest->AddData([
         'user' => $_POST['user'],
         'name' => $_POST['name'],
         'lastname' => $_POST['lastname'],
         'email' => $_POST['email'] ?? NULL,
         'password' => $_POST['password']
      ]);


      return $add_data_guest->status == false
         ? '<script>alert("Error al agregar registro"); location.href = "./guest"</script>'
         : '<script>alert("Datos registrados correctamente"); location.href = "./guests"</script>';
   }
}
