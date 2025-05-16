<?php
// app/Controllers/Registrar.php

namespace App\Controllers;

use App\Models\UsuariosModel; // Asegúrate de que el namespace y el nombre del modelo sean correctos
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface; // Importa RequestInterface
use CodeIgniter\HTTP\ResponseInterface; // Importa ResponseInterface
use Psr\Log\LoggerInterface; // Importa LoggerInterface

class Registrar extends Controller
{
    // Necesario para usar la validación y otras características
    protected $request;

    // Constructor si necesitas cargar helpers o inicializar cosas
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Carga el helper 'form' y 'url' (si no los tienes en autoload)
        helper(['form', 'url']);
    }

    // Método para mostrar el formulario de registro (si aún no lo tienes)
    public function index()
    {
        // Simplemente carga la vista del formulario (asegúrate de que la vista se llame 'registro')
        return view('registro');
    }

    // Método para procesar el formulario y guardar el usuario
    public function guardar()
    {
        // Carga la librería de validación (ya está disponible si usas initController)
        // $validation = \Config\Services::validation(); // No necesitas esto si usas $this->validate
        $validation = service('validation');
        // Define las reglas de validación
        $validation->setRules([
            'email' => [
                'rules' => 'required|valid_email|is_unique[usuario.mail]', // 'usuarios.mail' = tabla.columna
                'errors' => [
                    'required' => 'El correo es obligatorio.',
                    'valid_email' => 'Ingresa un correo electrónico válido.',
                    'is_unique' => 'Este correo ya está registrado.'
                ]
            ],
            'contraseña' => [ // Usa 'contraseña' para el nombre del campo del primer password
                'rules' => 'required|min_length[8]', // Puedes añadir reglas de seguridad más complejas
                'errors' => [
                    'required' => 'La contraseña es obligatoria.',
                    'min_length' => 'La contraseña debe tener al menos 8 caracteres.'
                ]
            ],
             // Usa 'recontraseña' para el nombre del campo de confirmación
            'recontraseña' => [
                'rules' => 'required|matches[contraseña]', // 'matches[contraseña]' compara con el campo 'contraseña'
                'errors' => [
                    'required' => 'Debes confirmar la contraseña.',
                    'matches' => 'Las contraseñas no coinciden.'
                ]
            ],
        ]);

        if (!$validation->withRequest($this->request)->run()){
            return redirect()->back()->withInput()->with('errors',$validation->getErrors());
        }

        // Si la validación pasa, procede a guardar
        $userModel = new UsuariosModel();

        // Prepara los datos para guardar
        $data = [
            'mail'=> $this->request->getPost('email'),
            // ¡HASHEA LA CONTRASEÑA ANTES DE GUARDAR!
            // password_hash() es la función segura de PHP recomendada
            'contraseña'=> password_hash($this->request->getPost('contraseña'), PASSWORD_DEFAULT),
            // No guardes 'recontraseña'
        ];

        // Guarda el usuario en la base de datos
        $userModel->insert($data);

        // Opcional: Establecer un mensaje flash de éxito
          $sessionData = [
                'mail'    => $this->request->getPost('email'), // O mejor $u['id_usuario'] si tienes un ID
                'isLoggedIn' => TRUE, // Bandera para verificar fácilmente el login
                // Agrega otros datos que necesites frecuentemente
            ];
            session()->set($sessionData); // Usar el helper global session()

            // 3. Redirigir a la página de inicio o dashboard
            // (Es mejor obtener las tareas en el controlador de la página de destino)
            return redirect()->to('/inicio'); // O la ruta que corresponda


    
        
    }
}
?>