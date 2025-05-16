<?php namespace App\Models;
use CodeIgniter\Model;
class UsuariosModel extends Model
{ protected $table = 'usuario'; 
    protected $primaryKey = 'mail';
protected $useAutoIncrement = true; protected $returnType = 'array';
protected $useSoftDeletes = false;
protected $allowedFields = ['mail','contraseña', 'nombre_usuario'];
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