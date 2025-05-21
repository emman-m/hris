<?php

namespace App\Models;

use CodeIgniter\Model;

class Memo extends Model
{
    protected $table            = 'memos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'file_path', 'created_by'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'title'     => 'required|min_length[3]|max_length[255]',
        'file_path' => 'required',
        'created_by' => 'required|numeric',
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Memo title is required',
            'min_length' => 'Memo title must be at least 3 characters long',
            'max_length' => 'Memo title cannot exceed 255 characters',
        ],
        'file_path' => [
            'required' => 'PDF file is required',
        ],
        'created_by' => [
            'required' => 'Creator is required',
            'numeric' => 'Invalid creator ID',
        ],
    ];

    protected $skipValidation = false;

    public function getMemosWithRecipients($id = null)
    {
        $builder = $this->db->table('memos')
            ->select('memos.*, CONCAT(users_info.first_name, " ", users_info.middle_name, " ", users_info.last_name) as creator_name')
            ->join('users_info', 'users_info.user_id = memos.created_by')
            ->where('memos.deleted_at IS NULL')
            ->orderBy('memos.created_at', 'DESC');
        
        if ($id !== null) {
            $builder->where('memos.id', $id);
        }
        
        $memos = $builder->get()->getResultArray();
        
        foreach ($memos as &$memo) {
            $recipients = $this->db->table('memo_recipients')
                ->select('users_info.user_id, CONCAT(users_info.first_name, " ", users_info.middle_name, " ", users_info.last_name) as name')
                ->join('users_info', 'users_info.user_id = memo_recipients.user_id')
                ->where('memo_recipients.memo_id', $memo['id'])
                ->get()
                ->getResultArray();
            
            $memo['recipients'] = $recipients;
        }
        
        return $memos;
    }

    /**
     * Get memos for dashboard where the current user is a recipient
     * 
     * @param int $userId Current user's ID
     * @param int $limit Number of memos to return
     * @return array
     */
    public function getDashboardMemos($userId, $limit = 5)
    {
        $builder = $this->db->table('memos')
            ->select('memos.*, CONCAT(users_info.first_name, " ", users_info.middle_name, " ", users_info.last_name) as creator_name')
            ->join('users_info', 'users_info.user_id = memos.created_by')
            ->join('memo_recipients', 'memo_recipients.memo_id = memos.id')
            ->where('memos.deleted_at IS NULL')
            ->where('memo_recipients.user_id', $userId)
            ->orderBy('memos.created_at', 'DESC')
            ->limit($limit);
        
        $memos = $builder->get()->getResultArray();

        // dd($this->getLastQuery()->getQuery());
        
        foreach ($memos as &$memo) {
            $recipients = $this->db->table('memo_recipients')
                ->select('users_info.user_id, CONCAT(users_info.first_name, " ", users_info.middle_name, " ", users_info.last_name) as name')
                ->join('users_info', 'users_info.user_id = memo_recipients.user_id')
                ->where('memo_recipients.memo_id', $memo['id'])
                ->get()
                ->getResultArray();
            
            $memo['recipients'] = $recipients;
        }
        
        return $memos;
    }

    public function addRecipients($memoId, $userIds)
    {
        $data = [];
        foreach ($userIds as $userId) {
            $data[] = [
                'memo_id' => $memoId,
                'user_id' => $userId,
                'created_at' => date('Y-m-d H:i:s')
            ];
        }
        
        return $this->db->table('memo_recipients')->insertBatch($data);
    }

    public function deleteRecipients($memoId)
    {
        return $this->db->table('memo_recipients')->where('memo_id', $memoId)->delete();
    }

    public function search(array $filters = [])
    {
        $builder = $this->table($this->table)
            ->select('memos.*, CONCAT(users_info.first_name, " ", users_info.middle_name, " ", users_info.last_name) as creator_name')
            ->join('users_info', 'users_info.user_id = memos.created_by')
            ->orderBy('memos.created_at', 'DESC')
            ->where('memos.deleted_at IS NULL');

        if (!empty($filters['search'])) {
            $builder->groupStart()
                ->orLike('memos.title', $filters['search'])
                ->orLike('users_info.first_name', $filters['search'])
                ->orLike('users_info.middle_name', $filters['search'])
                ->orLike('users_info.last_name', $filters['search'])
                ->groupEnd();
        }

        return $this;
    }

    
} 