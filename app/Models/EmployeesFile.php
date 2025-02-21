<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeesFile extends Model
{
    protected $table = 'employees_files';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'id',
        'user_id',
        'created_user',
        'file',
        'file_name',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function search(array $filters = [])
    {
        $builder = $this->table($this->table)
            ->select('
                employees_files.*,
                CONCAT(uic.first_name, " ", uic.middle_name, " ", uic.last_name) as uploaded_by')
            ->join('users_info uic', 'employees_files.created_user = uic.user_id', 'LEFT')
            ->orderBy('employees_files.updated_at', 'DESC')
            ->where('employees_files.deleted_at IS NULL');

        // Apply user id filter
        if (!empty($filters['user_id'])) {
            $builder->where('employees_files.user_id', $filters['user_id']);
        }

        // Apply search filter
        if (!empty($filters['search'])) {
            $builder->like('employees_files.file_name', '%' . $filters['search'] . '%');
        }

        return $builder;
    }
}
