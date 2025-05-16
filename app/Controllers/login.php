<?php
namespace App\Controllers;

use Config\Services;
use CodeIgniter\Controller; // Puede que no necesites esto si BaseController lo extiende
use App\Models\UsuariosModel;
use App\Models\TareasModel; // Necesitarías esto si cargas tareas aquí, pero mejor en otro controlador tras redirigir

class Login extends BaseController { // Asegúrate de que BaseController exista y extienda CodeIgniter\Controller

    // El constructor no necesita inicializar la sesión si BaseController ya lo hace.
    // Si no lo hace, podrías poner: public $session; ... $this->session = Services::session();
    public function __construct(){
        helper('form'); 
    }

    public function index() {
        // Pasar errores de sesión si existen (después de un intento fallido)
        $data = [];
        if (session()->has('error_message')) {
            $data['error_message'] = session()->getFlashdata('error_message');
        }
        return view('logeo', $data);
    }

    public function exito(){ // Renombrado para ser más descriptivo
        $userModel = new UsuariosModel();
        $request = Services::request(); // Acceso directo al servicio

        // Usar getPost() para datos de formulario POST
        $email_input = $request->getPost('email');
        $password_input = $request->getPost('contraseña');

        $u = $userModel->where('mail', $email_input)->first();

        // 1. Verificar si el usuario existe Y si la contraseña es correcta
        if ($u && password_verify($password_input, $u['contraseña'])) {
            // 2. Autenticación exitosa:
            // Configurar datos en la sesión (ej. email, id, nombre)
            $sessionData = [
                'mail'    => $u['mail'], // O mejor $u['id_usuario'] si tienes un ID
                'isLoggedIn' => TRUE, // Bandera para verificar fácilmente el login
                // Agrega otros datos que necesites frecuentemente
            ];
            session()->set($sessionData); // Usar el helper global session()

            // 3. Redirigir a la página de inicio o dashboard
            // (Es mejor obtener las tareas en el controlador de la página de destino)
            return redirect()->to('/inicio'); // O la ruta que corresponda

        } else {
            // 4. Autenticación fallida:
            // Establecer un mensaje de error temporal (flashdata)
            $error=[
                  'error'=>TRUE
             ];
                
            return view ('logeo',$error);
            // 5. Redirigir de vuelta al formulario de login
             // withInput() mantiene los datos antiguos del formulario (excepto password)
        }
    }

    // Opcional: Método para cerrar sesión
    public function logout() {
        session()->destroy(); // Elimina todos los datos de la sesión
        return redirect()->to('/'); // Redirige a la página principal o login
    }
}