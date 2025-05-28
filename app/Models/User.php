<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use CodeIgniter\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'id',
        'role',
        'email',
        'password',
        'status',
        'code',
        'created_at',
        'updated_at',
        'deleted_at'
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

    public function validateStatusUpdate($status)
    {
        return in_array($status, [UserStatus::ACTIVE->value, UserStatus::INACTIVE->value]);
    }
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

    public function getUserByEmail($email)
    {
        return $this->where('users.email', $email)
            ->join('users_info', 'users.id = users_info.user_id', 'LEFT')
            ->first();
    }

    public function getUserByuserId($id)
    {
        return $this->select('users.*, users_info.*, employees_info.employee_id, employees_info.department')
            ->where('users.id', $id)
            ->join('users_info', 'users.id = users_info.user_id', 'LEFT')
            ->join('employees_info', 'users.id = employees_info.user_id', 'LEFT')
            ->first();
    }

    public function getDepartmentHead($department)
    {
        return $this->select('
                CONCAT(users_info.first_name, " ", users_info.last_name) as name,
                users.*,
                users_info.*,
                employees_info.employee_id,
                employees_info.department
            ')
            ->where('employees_info.is_department_head', '1')
            ->where('employees_info.department', $department)
            ->join('users_info', 'users.id = users_info.user_id', 'LEFT')
            ->join('employees_info', 'users.id = employees_info.user_id', 'LEFT')
            ->first();
    }

    public function getFilteredQuery(array $filters = [])
    {
        $builder = $this->table($this->table)
            ->select('
            CONCAT(users_info.first_name, " ", users_info.middle_name, " ", users_info.last_name) as name,
            users.email,
            users.role,
            users.status,
            users_info.*,
            employees_info.department,
            employees_info.is_locked,
            employees_info.employee_id,
        ')
            ->join('users_info', 'users.id = users_info.user_id')
            ->join('employees_info', 'users.id = employees_info.user_id', 'LEFT')
            ->orderBy('users.status', 'ASC')
            ->orderBy('users.updated_at', 'DESC')
            ->where('users.deleted_at IS NULL');

        // Apply role filter
        if (!empty($filters['role'])) {
            $builder->where('users.role', $filters['role']);
        }

        // Apply status filter
        if (!empty($filters['status'])) {
            $builder->where('users.status', $filters['status']);
        }

        // Apply search filter
        if (!empty($filters['search'])) {
            $builder->groupStart()
                ->like('users_info.first_name', $filters['search'])
                ->orLike('users_info.last_name', $filters['search'])
                ->orLike('users_info.middle_name', $filters['search'])
                ->orLike("CONCAT(users_info.first_name, ' ', users_info.middle_name, ' ', users_info.last_name)", "%{$filters['search']}%")
                ->orLike('users.email', $filters['search'])
                ->orLike('employees_info.employee_id', $filters['search'])
                ->groupEnd();
        }

        // Apply department filter
        if (!empty($filters['department'])) {
            $builder->where('employees_info.department', $filters['department']);
        }

        return $builder;
    }

    public function getAllAdmin()
    {
        return $this->builder($this->table)
            ->select('CONCAT(users_info.first_name, " ", users_info.middle_name, " ", users_info.last_name) as name, users.*, users.role')
            ->join('users_info', 'users_info.user_id = users.id', 'LEFT')
            ->whereIn('users.role', [UserRole::ADMIN->value, UserRole::HR_ADMIN->value, UserRole::HR_STAFF->value])
            ->get()->getResultArray();
    }
}
