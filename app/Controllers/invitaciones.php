<?php
namespace App\Controllers;
use App\Models\ColaboradorModel;
class Invitaciones extends BaseController {
    public function __construct(){

        $this->session = \Config\Services::session();

    }
    public function index(){
    
       
    }
    public function aceptar() {
        $colaboradoresModel = new ColaboradorModel();


    $data = [
        'estado' => 1,
    ];
   
    $colaboradoresModel->update($this->request->getPost('id_colaborador'),$data); 
      return redirect()->back();
      }
public function rechazar(){
    $invitacion = new colaboradorModel();
    $id = $this->request->getPost('invitacion_id');
    $invitacion->where('id_colaborador',$id)->delete();
      return redirect()->back();
}
    }

 
?>