<?php

namespace App\Models;

use CodeIgniter\Model;

class Attendance extends Model
{
    protected $table = 'attendances';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'employee_id',
        'remark',
        'machine',
        'transaction_date',
        'time_in',
        'time_out'
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
            CONCAT(users_info.first_name, " ", users_info.middle_name, " ", users_info.last_name) as name,
            attendances.*,
        ')
            ->join('employees_info', 'attendances.employee_id = employees_info.employee_id', 'LEFT')
            ->join('users_info', 'employees_info.user_id = users_info.user_id', 'LEFT')
            ->orderBy('attendances.transaction_date', 'DESC')
            ->where('attendances.deleted_at IS NULL');

        if (!empty($filters['from'])) {
            $builder->where('attendances.transaction_date >=', $filters['from']);
        }

        if (!empty($filters['to'])) {
            $builder->where('attendances.transaction_date <=', $filters['to']);
        }

        if (!empty($filters['search'])) {
            $builder->groupStart() // Start grouping the search conditions
                ->orLike('users_info.first_name', $filters['search'])
                ->orLike('users_info.middle_name', $filters['search'])
                ->orLike('users_info.last_name', $filters['search'])
                ->orLike('attendances.employee_id', $filters['search'])
                ->groupEnd(); // End grouping the search conditions
        }

        // if employee
        $employeeId = session()->get('employee_id') ?? null;
        if (!empty($employeeId)) {
            $builder->where('attendances.employee_id', $employeeId);
        }

        return $builder;
    }
}
