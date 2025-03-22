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
        $builder = $this->table($this->table);

        if (!empty($filters['search'])) {
            $builder->like('title', $filters['search']);
            $builder->orLike('content', $filters['search']);
        }

        return $builder;
    }

    public function withDeleted(bool $val = true)
    {
        if ($val) {
            return $this->table($this->table)->where('deleted_at IS NOT NULL OR deleted_at IS NULL');
        }
        return $this->table($this->table)->where('deleted_at IS NULL');
    }
}
