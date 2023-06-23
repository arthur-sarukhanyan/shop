<?php

namespace App\Helpers;

trait PaginationHelper
{
    /**
     * Create pagination array
     *
     * @param array $params
     * @param int $count
     * @return array
     */
    public function createPagination(array $params, int $count): array
    {
        $offset = $params['pagination']['offset'];
        $limit = $params['pagination']['limit'];

        $total = intval(ceil($count/$limit));
        $current = ($offset / $limit) + 1;
        $next = $current + 1;
        if ($next > $total) {
            $next = $total;
        }

        $previous = $current - 1;
        if ($previous < 1) {
            $previous = 1;
        }

        return [
            'total' => $total,
            'current' => $current,
            'previous' => $previous,
            'next' => $next,
        ];
    }

    /**
     * Check if filers were added to request
     *
     * @param array $params
     * @return bool
     */
    public function needsFilteredCount(array $params): bool
    {
        if (array_key_exists('filters', $params) && count($params['filters'])) {
            return true;
        }

        return false;
    }

    /**
     * Parse page to offset/limit from request
     *
     * @param int $page
     * @return array
     */
    public function createPaginationFromPage(int $page): array
    {
        --$page;
        if ($page < 0) {
            $page = 0;
        }

        $limit = intval(env('PAGINATION_LIMIT', 15));

        $offset = $page * $limit;
        return ['offset' => $offset, 'limit' => $limit];
    }
}
