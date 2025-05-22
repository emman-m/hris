<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeInfo extends Model
{
    protected $table = 'employees_info';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'id',
        'user_id',
        'is_locked',
        'is_department_head',
        'employee_id',
        'department',
        'birth',
        'birth_place',
        'gender',
        'status',
        'spouse',
        'permanent_address',
        'present_address',
        'fathers_name',
        'mothers_name',
        'mothers_maiden_name',
        'religion',
        'tel',
        'phone',
        'nationality',
        'sss',
        'date_of_coverage',
        'pagibig',
        'tin',
        'philhealth',
        'res_cert_no',
        'res_issued_on',
        'res_issued_at',
        'contact_person',
        'contact_person_no',
        'contact_person_relation',
        'employment_date',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'is_locked' => 'bool'
    ];
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

    public function findByUserId($userId)
    {
        return $this->table($this->table)->select('*')
            ->where('user_id', $userId);
    }

    public function idAs($alias)
    {
        return $this->select("id as $alias");
    }

    public function getUserFromDept($department)
    {
        $depts = normalizeArray($department);

        $builder = $this->table($this->table)
            ->select('users.*, users_info.first_name, users_info.last_name')
            ->whereIn('employees_info.department', $depts)
            ->join('users', 'employees_info.user_id = users.id', 'LEFT')
            ->join('users_info', 'users_info.user_id = users.id', 'LEFT');

        return $builder->get()->getResultArray();
    }

    public function getEmployeeInfoByEmployeeId($employeeId)
    {
        return $this->where('employees_info.employee_id', $employeeId)
            ->first();
    }
}
