<?php

namespace App\Models;

use CodeIgniter\Model;

class UserInfo extends Model
{
    protected $table            = 'users_info';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
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
        'deleted_at',
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
}
