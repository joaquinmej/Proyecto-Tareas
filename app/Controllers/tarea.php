<?php
namespace App\Controllers;
use App\Models\tareasModel;
use App\Models\subtareasModel;
use App\Models\ColaboradorModel;
use App\Models\UsuariosModel;
class Tarea extends BaseController {
    public function __construct(){

        $this->session = \Config\Services::session();
        helper(['form']);
    }
    public function index(){
        if (!$this->session->get('mail')) {
            
            return redirect()->to('/login');
        }
        $emailGuardado = $this->session->get('mail');
        $tareasModel = new TareasModel();
        $tareas=$tareasModel->where('responsable',$emailGuardado)->findAll();
        $data = [
            'tareas' => $tareas,
        ];

       return view('tarea',$data);

       
    }
    public function vertarea($id){

        $tareaModel = new TareasModel();
        $subtareaModel = new SubtareasModel();
        $colaboradorModel = new ColaboradorModel();
        $tarea=$tareaModel->where('id_tarea',$id)->first();
        $subtarea=$subtareaModel->where('id_tarea',$id)->findAll();
        $colaboradores = $colaboradorModel
 ->where('id_tarea', $id)
 ->where('estado', 1)
 ->findAll();
$data=[
    'tarea' => $tarea,
    'subtareas'=>$subtarea,
'colaboradores' => $colaboradores,
];
return view('tarea',$data);
}
//borrar un tarea
public function borrar($id){
    $tareaModel = new TareasModel();
    $tareaModel->where('id_tarea',$id)->delete();

        return redirect()->to(base_url('inicio'));

}
// guardar el modificar una tarea
public function modificar($id){
    $tareaModel = new TareasModel();
    $tarea=$tareaModel->where('id_tarea',$id)->first();
    $data =[
        'tarea' => $tarea,
    ];
  return view('modificar',$data);

}
public function modificart(){

    $validation = service('validation');

    // Define las reglas de validación
    $validation->setRules([
        
        'fecha_vencimiento' => [
            // Asumiendo que el input type="date" envía AAAA-MM-DD
            'rules' => 'es_futuro',
            'errors' => [
                'es_futuro' => 'la fecha debe ser en el futuro'
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
    $fechaVencimiento = $this->request->getPost('fecha_vencimiento');
    $fechaRecordatorio = $this->request->getPost('fecha_recordatorio');

    // Convierte las cadenas vacías a NULL para los campos de fecha opcionales
    // Esto es crucial si la columna de la base de datos permite NULL pero no cadenas vacías
    if (empty($fechaRecordatorio)) {
        $fechaRecordatorio = null;
    }

    $tareaModel = new TareasModel();
     $id = $this->request->getPost('tarea_id');
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
    log_message('debug', 'ID de tarea recibido: ' . $id);
  
    $tareaModel->update($id, $data);
    // Redirige al usuario (por ejemplo, a la página de inicio)
    return redirect()->to(base_url('inicio'));
}
//cargar formulario
public function modificarsub($idta,$id){

     $subtareaModel = new SubtareasModel();
       $tareaModel = new TareasModel();
        $subtarea=$subtareaModel->where('id_sub',$id)->first();
 $colaboradorModel = new ColaboradorModel();
 $colaboradores = $colaboradorModel
 ->where('id_tarea', $idta)
 ->where('estado', 1)
 ->findAll();

 $tarea=$tareaModel->where('id_tarea',$idta)->first();
       $data = [
        'tarea' =>$tarea,
        'subtarea'=> $subtarea,
        'colaboradores'=>$colaboradores,
       ];

       return view('modificarsub',$data);
}

// guardar el modificar una subtarea
public function guardarmod(){
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
    $id = $this->request->getPost('id_subtarea');
        // Verificar si el valor recibido es la cadena "null"
        if ($responsable === 'null') {
            $responsable = null; // Usar el valor NULL de PHP
        }
   if (empty($fechaVencimiento)) {
    $fechaVencimiento = null;
}
  // Prepara los datos para guardar
  $data = [
    'tema'               => $this->request->getPost('tema'),
    'descripcion'        => $this->request->getPost('descripcion'),
    'comentario'         =>$this->request->getPost('comentario'),
    'prioridad'          => $this->request->getPost('prioridad'),
    'fecha_vencimiento'  => $fechaVencimiento, // Usa la variable corregida
    'responsable'        => $responsable,
];
$subtareaModel = new SubtareasModel();
$subtareaModel->update($id, $data);
return redirect()->to( site_url('tarea/vertarea/'.$this->request->getPost('id_tarea')));

}

public function borrarsub($id,$idt){
    $subtareaModel = new SubtareasModel();
    $subtareaModel->where('id_sub',$id)->delete();

    return redirect()->to( site_url('tarea/vertarea/'.$idt));
}
public function cambiarestadosub(){
    $tareaModel = new TareasModel();
    $subtareaModel = new SubtareasModel();
$data = [
 'estado' => $this->request->getPost('estado'),
];
$subtareaModel->update($this->request->getPost('subtarea_id'), $data);

if($this->request->getPost('estadot') == 0 && $this->request->getPost('estado') == 2 ){
    $dato = [
        'estado' => 1,
    ];
    $tareaModel->update($this->request->getPost('tarea_id'),$dato);
}
if($this->request->getPost('estadot') == 2 && $this->request->getPost('estado') != 2 ){
    $dato = [
        'estado' => 1,
    ];
    $tareaModel->update($this->request->getPost('tarea_id'),$dato);
}


return redirect()->to( site_url('tarea/vertarea/'.$this->request->getPost('tarea_id')));
}
public function cambiarestado(){
     $tareasModel = new TareasModel();
     $subtareaModel = new SubtareasModel();

     $subtareas = $subtareaModel->where('id_tarea',$this->request->getPost('tarea_id'))->findAll();

   if($this->request->getPost('estado') == 2){
if(!$subtareas){
$data = [
 'estado' => $this->request->getPost('estado'),
];

$tareasModel->update($this->request->getPost('tarea_id'),$data);

return redirect()->to( site_url('tarea/vertarea/'.$this->request->getPost('tarea_id')));
}else
$completo = 0;
foreach ($subtareas as $tarea){
if($tarea['estado'] != 2){
    $completo = 1;
}
}
if($completo == 0){
    $data = [
 'estado' => $this->request->getPost('estado'),
];

$tareasModel->update($this->request->getPost('tarea_id'),$data);

return redirect()->to( site_url('tarea/vertarea/'.$this->request->getPost('tarea_id')));

   }  
return redirect()->back()->with('no_completo', 'debes tener completa todas las subtareas');
}
$data = [
 'estado' => $this->request->getPost('estado'),
];

$tareasModel->update($this->request->getPost('tarea_id'),$data);

return redirect()->to( site_url('tarea/vertarea/'.$this->request->getPost('tarea_id')));

   
}

public function invitarcolaborador(){

        // Usar getPost() para datos de formulario POST
        $email_input = $this->request->getPost('email_colaborador');
        $id = $this->request->getPost('tarea_id');
         $usuarios = new usuariosModel();
   $colaboradores = new ColaboradorModel();
   $usuario = $usuarios->where('mail',$email_input)->first();
   $colaborador = $colaboradores
   ->where('id_tarea',$id)
   ->where('usuario_colaborador',$email_input)
   ->first(); 

        // 1. Verificar si el usuario existe Y si la contraseña es correcta
        if ($usuario && !$colaborador) {
            
        $data = [
            'id_tarea' => $id,
            'usuario_colaborador' => $email_input,
            'estado' => 0,
        ];
        $colaboradores->insert($data);
           
 return redirect()->back()->with('exito_invitacion', 'Invitación enviada con éxito.');

        } else if(!$usuario){
            
           return redirect()->back()->with('no_existe', 'el usuario no existe.');
            // 5. Redirigir de vuelta al formulario de login
             // withInput() mantiene los datos antiguos del formulario (excepto password)
        }
        else{

             return redirect()->back()->with('no_existe', 'El usuario ya fue invitado.');
        }
}

public function archivar($id){
     $tarea = new TareasModel();

     $data = [
        'estado' => 3,
     ];
     $tarea->update($id,$data);
     return redirect()->back()->with('archivada', 'La tarea fue archivada.');
}


}
?>