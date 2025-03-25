<?php

namespace App\Services;

use App\Libraries\Policy\AuthPolicy;
use App\Models\Announcement;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Services;

class WidgetService
{
    public static function getAnnouncement(Announcement $announcement, AuthPolicy $auth, array $filters = [])
    {
        // Get the query builder from the model
        $queryBuilder = $announcement->search($filters);

        // Auth user
        if ($auth->isEmployee()) {
            $queryBuilder = $queryBuilder->validUser();
        }

        // Apply pagination
        $data = $queryBuilder->paginate(1);
        $pager = $queryBuilder->pager;

        // Pagination meta
        $paginationInfo = [
            'totalItems' => $pager->getTotal(),
            'start' => ($pager->getCurrentPage() - 1) * $pager->getPerPage() + 1,
            'end' => min($pager->getCurrentPage() * $pager->getPerPage(), $pager->getTotal()),
        ];

        return [
            'data' => $data,
            'pager' => $pager,
            'paginationInfo' => $paginationInfo,
        ];
    }
}