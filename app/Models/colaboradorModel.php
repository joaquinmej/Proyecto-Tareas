<?php namespace App\Models;
use CodeIgniter\Model;
class ColaboradorModel extends Model
{ protected $table = 'colaborador'; 
    protected $primaryKey = 'id_colaborador';
protected $useAutoIncrement = true; protected $returnType = 'array';
protected $useSoftDeletes = false;
protected $allowedFields = ['id_tarea','usuario_colaborador','estado'];
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