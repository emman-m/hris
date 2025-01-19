<?php

namespace App\Models;

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
        'role',
        'email',
        'password',
        'status',
        'code',
        'created_at',
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
        return $this->where('email', $email)->first();
    }

    public function getFilteredQuery(array $filters = [])
    {
        $builder = $this->table($this->table)
            ->select('
            CONCAT(users_info.first_name, " ", users_info.middle_name, " ", users_info.last_name) as name,
            users.email,
            users.role,
            users.status,
            users_info.*
        ')
            ->join('users_info', 'users.id = users_info.user_id');

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
                ->orLike('users.email', $filters['search'])
                ->groupEnd();
        }

        return $builder;
    }

}
