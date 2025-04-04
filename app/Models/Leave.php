<?php

namespace App\Models;

use CodeIgniter\Model;

class Leave extends Model
{
    protected $table = 'leaves';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'user_id',
        'status',
        'type',
        'vl_type',
        'reason',
        'days',
        'start_date',
        'end_date',
        'department',
        'institution',
        'venue',
        'time_in',
        'time_out',
        'approve_user',
        'approve_date',
        'approval_proof'
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

    public function search($filters = [])
    {
        $builder = $this->table($this->table)
            ->select('
                CONCAT(users_info.first_name, " ", users_info.last_name) as name,
                CONCAT(admin_user.first_name, " ", admin_user.last_name) as approve_by,
                leaves.*
                ')
            ->join('users_info', 'leaves.user_id = users_info.user_id', 'LEFT')
            ->join('users_info as admin_user', 'leaves.approve_user = admin_user.user_id', 'LEFT')
            ->join('employees_info', 'leaves.user_id = employees_info.user_id', 'LEFT')
            ->join('users', 'leaves.user_id = users.id', 'LEFT');

        if (!empty($filters['type'])) {
            $builder->where('leaves.type', $filters['type']);
        }

        if (!empty($filters['vl_type'])) {
            $builder->where('leaves.vl_type', $filters['vl_type']);
        }

        if (!empty($filters['status'])) {
            $builder->where('leaves.status', $filters['status']);
        }

        if (!empty($filters['start_date'])) {
            $builder->where('leaves.start_date >=', $filters['start_date']);
        }

        if (!empty($filters['search'])) {
            $builder->groupStart()
                ->like('users_info.first_name', $filters['search'])
                ->orLike('users_info.last_name', $filters['search'])
                ->orLike('employees_info.employee_id', $filters['search'])
                ->orLike('users.email', $filters['search'])
                ->groupEnd();
        }

        $builder->orderBy('leaves.updated_at', 'DESC');

        return $this;
    }

    public function employee()
    {
        $this->where('leaves.user_id', session()->get('user_id'));

        return $this;
    }

    public function findById($id)
    {
        $builder = $this->table($this->table)
            ->select('
                CONCAT(users_info.first_name, " ", users_info.last_name) as name,
                CONCAT(admin_user.first_name, " ", admin_user.last_name) as approve_by,
                leaves.*,
                users.email,
                users.id as user_id
                ')
            ->join('users_info', 'leaves.user_id = users_info.user_id', 'LEFT')
            ->join('users_info as admin_user', 'leaves.approve_user = admin_user.user_id', 'LEFT')
            ->join('employees_info', 'leaves.user_id = employees_info.user_id', 'LEFT')
            ->join('users', 'leaves.user_id = users.id', 'LEFT')
            ->where('leaves.deleted_at', null)
            ->where('leaves.id', $id);

        return $builder->get()->getRowArray();
    }
}
