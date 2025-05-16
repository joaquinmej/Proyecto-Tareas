<?php namespace App\Validation;

use CodeIgniter\Validation\Rules;

class ValidacionFecha extends Rules
{
    public function es_futuro($fecha)
    {
        $fecha_actual = date('Y-m-d');
      if($fecha > $fecha_actual){
return true;
      }else
      return false;
    }

}
?>