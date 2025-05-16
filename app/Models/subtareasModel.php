<?php namespace App\Models;
use CodeIgniter\Model;
class SubtareasModel extends Model
{ protected $table = 'subtarea'; 
    protected $primaryKey = 'id_sub';
protected $useAutoIncrement = true; protected $returnType = 'array';
protected $useSoftDeletes = false;
protected $allowedFields = ['id_tarea','tema','descripcion','prioridad', 'estado',' fecha_vencimiento','responsable','comentario'];
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