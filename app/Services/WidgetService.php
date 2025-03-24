<?php

namespace App\Services;

use App\Models\Announcement;
use Config\Services;

class WidgetService
{

    public static function getAnnouncement(Announcement $announcement, array $filters = [])
    {
        // Get the query builder from the model
        $queryBuilder = $announcement->search($filters);

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