<?php
// app/Controllers/CrearTarea.php

namespace App\Controllers;

use App\Models\TareasModel; // Asegúrate de que el namespace y el nombre del modelo sean correctos
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface; // Importa RequestInterface
use CodeIgniter\HTTP\ResponseInterface; // Importa ResponseInterface
use Psr\Log\LoggerInterface; // Importa LoggerInterface
use DateTime; // Importa la clase DateTime
use App\Models\subtareasModel;
use App\Models\ColaboradorModel;
class CrearTarea extends Controller
{
    // Necesario para usar la validación y otras características
    protected $request;
    protected $session; // Declara la propiedad session

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Carga el helper 'form' y 'url' (si no los tienes en autoload)
        helper(['form', 'url']);

        // Inicializa la sesión
        $this->session = \Config\Services::session();
    }

    // Método para mostrar el formulario de crear tarea
    public function index()
    {
        // Simplemente carga la vista del formulario (asegúrate de que la vista se llame 'creatarea')
        return view('creatarea');
    }

    // Método para procesar el formulario y guardar la tarea
    public function guardar()
    {
        // Carga la librería de validación
        $validation = service('validation');

        // Define las reglas de validación
        $validation->setRules([
            'tema' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El tema es obligatorio.',
                ]
            ],
            'fecha_vencimiento' => [
                // Asumiendo que el input type="date" envía AAAA-MM-DD
                'rules' => 'required|valid_date[Y-m-d]|es_futuro',
                'errors' => [
                    'required' => 'La fecha de vencimiento es obligatoria.',
                    'valid_date' => 'La fecha de vencimiento debe ser una fecha válida.',
                    'es_futuro' => 'la fecha debe ser en el futuro'
                ]
            ],
            'descripcion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'La descripción es obligatoria.',
                ]
            ],
             // Añadir validación para fecha_recordatorio si es necesario
             'fecha_recordatorio' => [
                'rules' => 'permit_empty|valid_date[Y-m-d]', // Permite vacío, pero si se llena, valida formato
                'errors' => [
                    'valid_date' => 'La fecha de recordatorio debe ser una fecha válida.',
                ]
            ],
        ]);

        // Ejecuta la validación
        if (!$validation->withRequest($this->request)->run()){
            // Si la validación falla, redirige de vuelta con los errores y los datos ingresados
            return redirect()->back()->withInput()->with('errors',$validation->getErrors());
        }

     
        // Obtén los valores de fecha del POST
        $fechaVencimiento = $this->request->getPost('fecha_vencimiento');
        $fechaRecordatorio = $this->request->getPost('fecha_recordatorio');

        // Convierte las cadenas vacías a NULL para los campos de fecha opcionales
        // Esto es crucial si la columna de la base de datos permite NULL pero no cadenas vacías
        if (empty($fechaRecordatorio)) {
            $fechaRecordatorio = null;
        }

    

        // Si la validación pasa, procede a guardar
        $tareaModel = new TareasModel();

        // Determina el color basado en la prioridad
        $prioridad = $this->request->getPost('prioridad');
        $color = "#3fe51a"; // Verde por defecto (prioridad 0)
        if ($prioridad == 1) {
            $color = "#e9ec18"; // Amarillo
        } elseif ($prioridad == 2) {
            $color = "#f32222"; // Rojo
        }

        // Prepara los datos para guardar
        $data = [
            'tema'               => $this->request->getPost('tema'),
            'descripcion'        => $this->request->getPost('descripcion'),
            'estado'             => 0, // Estado inicial, por ejemplo, 'Pendiente'
            'prioridad'          => $this->request->getPost('prioridad'),
            'fecha_vencimiento'  => $fechaVencimiento, // Usa la variable corregida
            'fecha_recordatorio' => $fechaRecordatorio, // Usa la variable corregida
            'color'              => $color,
            'responsable'        => $this->session->get('mail'), // Asegúrate de que 'mail' está en la sesión
        ];

        // Guarda la tarea en la base de datos
        log_message('debug', 'Datos a insertar: ' . print_r($data, true));
        $tareaModel->insert($data);

        // Opcional: Establecer un mensaje flash de éxito
        $this->session->setFlashdata('success', 'Tarea creada exitosamente.');

        // Redirige al usuario (por ejemplo, a la página de inicio)
        return redirect()->to(base_url('inicio'));
    }
public function crearsub($id){
    $tareaModel = new TareasModel();
    $tarea=$tareaModel->where('id_tarea',$id)->first();
    $colaboradorModel = new ColaboradorModel();
$colaboradores = $colaboradorModel
->where('id_tarea', $id)
->where('estado', 1)
->findAll();
    $data =[
        'tarea' => $tarea,
        'colaboradores' => $colaboradores
    ];
  return view('crearsub',$data);
 
}

public function guardarsub(){
 $validation = service('validation');

  // Define las reglas de validación
  $validation->setRules([
      'tema' => [
          'rules' => 'required',
          'errors' => [
              'required' => 'El tema es obligatorio.',
          ]
      ],
      'fecha_vencimiento' => [
          // Asumiendo que el input type="date" envía AAAA-MM-DD
          'rules' => 'permit_empty|es_futuro',
          'errors' => [
              'es_futuro' => 'la fecha debe ser en el futuro'
          ]
      ],
      'descripcion' => [
          'rules' => 'required',
          'errors' => [
              'required' => 'La descripción es obligatoria.',
          ]
      ],
    
      
  ]);

  // Ejecuta la validación
  if (!$validation->withRequest($this->request)->run()){
      // Si la validación falla, redirige de vuelta con los errores y los datos ingresados
      return redirect()->back()->withInput()->with('errors',$validation->getErrors());
  }
   // Obtén los valores de fecha del POST
   $fechaVencimiento = $this->request->getPost('fecha_vencimiento');
   $responsable = $this->request->getPost('responsable');

        // Verificar si el valor recibido es la cadena "null"
        if ($responsable === 'null') {
            $responsable = null; // Usar el valor NULL de PHP
        }
   if (empty($fechaVencimiento)) {
    $fechaVencimiento = null;
}
  // Prepara los datos para guardar
  $data = [
    
    'id_tarea'               => $this->request->getPost('id_tarea'),
    'tema'               => $this->request->getPost('tema'),
    'descripcion'        => $this->request->getPost('descripcion'),
    'estado'             => 0, // Estado inicial, por ejemplo, 'Pendiente'
    'prioridad'          => $this->request->getPost('prioridad'),
    'fecha_vencimiento'  => $fechaVencimiento, // Usa la variable corregida
    'responsable'        => $responsable,
];
$subtareaModel = new SubtareasModel();
$subtareaModel->insert($data);
return redirect()->to( site_url('tarea/vertarea/'.$this->request->getPost('id_tarea')));

}
}
?>