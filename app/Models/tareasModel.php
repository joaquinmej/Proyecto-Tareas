<?php namespace App\Models;
use CodeIgniter\Model;
class TareasModel extends Model
{ protected $table = 'tarea'; 
    protected $primaryKey = 'id_tarea';
protected $useAutoIncrement = true; protected $returnType = 'array';
protected $useSoftDeletes = false;
protected $allowedFields = ['id_tarea','tema','descripcion','prioridad', 'estado','fecha_vencimiento','fecha_recordatorio','color','responsable'];
protected $useTimestamps = false; // Dates
protected $dateFormat = 'datetime';
protected $createdField = 'created_at';
protected $updatedField = 'updated_at';
protected $deletedField = 'deleted_at';
protected $validationRules = []; // Validation
protected $validationMessages = [];
protected $skipValidation = false;
protected $cleanValidationRules = true;
}
?>  