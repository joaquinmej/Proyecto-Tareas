<?php
namespace App\Controllers;
use App\Models\tareasModel;
use App\Models\ColaboradorModel;
class Archivar extends BaseController {
    public function __construct(){

        $this->session = \Config\Services::session();

    }
    public function index(){
        if (!$this->session->get('mail')) {
            
            return redirect()->to('/login');
        }
        $emailGuardado = $this->session->get('mail');
        $tareasModel = new TareasModel();
        $colaboradoresModel = new ColaboradorModel();
        $invitaciones = $colaboradoresModel
    ->select('tarea.*,colaborador.id_colaborador') // Selecciona todas las columnas de la tabla 'tarea'
    ->join('tarea', 'tarea.id_tarea = colaborador.id_tarea') // Une la tabla 'colaborador' con 'tarea'
    ->where('colaborador.usuario_colaborador', $emailGuardado) // Filtra por el ID del usuario colaborador
    ->where('colaborador.estado', 0) // Filtra por el estado de colaboración = 0
    ->findAll(); // Ejecuta la consulta y trae todos los resultados que coinciden

        $tareas=$tareasModel->where('responsable',$emailGuardado)
                            ->where('estado',3)     
                            ->findAll();
        $data = [
            'tareas' => $tareas,
            'invitaciones' => $invitaciones,

        ];

       return view('archivadas',$data);

       
    }
}
?>