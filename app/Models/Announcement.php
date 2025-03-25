<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\User;

class Announcement extends Model
{
    protected $table = 'announcements';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'created_id',
        'target',
        'title',
        'content',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'target' => 'json',
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

    public function search(array $filters)
    {
        $builder = $this->table($this->table)
            ->select('
                announcements.*,
                CONCAT(users_info.first_name, " ", users_info.last_name) as author
            ')
            ->join('users_info', 'announcements.created_id = users_info.user_id', 'LEFT');

        if (!empty($filters['search'])) {
            $builder->like('announcements.title', $filters['search']);
            $builder->orLike('announcements.content', $filters['search']);
        }

        $builder->orderBy('announcements.created_at', 'desc');

        return $this;
    }

    public function withDeleted(bool $val = true)
    {
        if ($val) {
            return $this->table($this->table)->where('announcements.deleted_at IS NOT NULL OR deleted_at IS NULL');
        }

        return $this->table($this->table)->where('announcements.deleted_at IS NULL');
    }

    public function validUser()
    {
        $userId = session()->get('user_id');

        return $this->join('employees_info', 'employees_info.user_id = '. $userId, 'LEFT')
            ->where("JSON_CONTAINS(announcements.target, JSON_QUOTE(employees_info.department))")
            ->where('employees_info.user_id', $userId);
    }
}
