<?php

namespace App\Models;

use CodeIgniter\Model;

class PositionHistory extends Model
{
    protected $table            = 'position_history';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'is_current',
        'position',
        'year_from',
        'year_to',
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
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function findAllPastByUserId($userId)
    {
        return $this->where('user_id', $userId)
            ->where('is_current', false)
            ->findAll();
    }
    public function findAllCurrentByUserId($userId)
    {
        return $this->where('user_id', $userId)
            ->where('is_current', true)
            ->findAll();
    }
}
