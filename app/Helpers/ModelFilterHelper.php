<?php

namespace App\Helpers;

use App\Models\Relations\BelongsToManyByPath;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

/**
 * Params structure is fixed and should be like this
 * [
 *      ?'filters' => [
 *          ['field' => 'name', 'value' => 'test', ?'type' => '='].
 *          [...]
 *      ],
 *      ?'order' => ['field' => 'name', 'type' => 'ASC'],
 *      ?'pagination' => ['offset' => 0, 'limit' => 10]
 * ]
 */
trait ModelFilterHelper
{
    protected array $defaultOrder = ['field' => 'id', 'type' => 'DESC'];
    protected string $defaultSeparator = '>';

    /**
     * if dot exists, then it's related column (ex. categories.name)
     * otherwise colum is from base model
     *
     * @param string $column
     * @return bool
     */
    public function isFromModel(string $column): bool
    {
        if (!str_contains($column, $this->defaultSeparator)) {
            return true;
        }

        return false;
    }

    /**
     * If type is not defined in filter, then its '=', else
     * condition type is 'type from filter'
     *
     * @param array $filter
     * @return string
     */
    public function conditionType(array $filter): string
    {
        if (array_key_exists('type', $filter)) {
            return $filter['type'];
        }

        return '=';
    }

    /**
     * return word before '.', or null, if string doesn't
     * contain dot
     *
     * @param string $column
     * @return string|null
     */
    public function getRelationName(string $column): string|null
    {
        if ($this->isFromModel($column)) {
            return null;
        }

        return explode($this->defaultSeparator, $column)[0];
    }

    /**
     * Check if relation method exists in model class
     *
     * @param string $className
     * @param string $relationName
     * @return bool
     */
    public function relationExists(string $className, string $relationName): bool
    {
        return method_exists($className, $relationName);
    }

    /**
     * This part is connected with BelongsToManyByPath relation
     * In this case relation name might be replaced with alias 'pta'
     * (ex. allCategories)
     *
     * @param string $className
     * @param string $column
     * @return string
     */
    public function replaceRelationAlias(string $className, string $column): string
    {
        if (!str_contains($column, $this->defaultSeparator)) {
            return $column;
        }

        $parts = explode($this->defaultSeparator, $column);

        if (!defined($className . '::ALIAS_RELATIONS') || !is_array($className::ALIAS_RELATIONS) || !in_array($parts[0], $className::ALIAS_RELATIONS)) {
            return $parts[1];
        } else {
            return BelongsToManyByPath::PATH_TABLE_ALIAS . '.' . $parts[1];
        }
    }

    /**
     * Take 'order'/'filters'/... from params
     *
     * @param array $params
     * @param string $item
     * @return array|null
     */
    public function getParamsItem(array $params, string $item): array|null
    {
        if (array_key_exists($item, $params)) {
            return $params[$item];
        }

        return null;
    }

    public function updateParams(array $params): array
    {
        $newParams = [];

        $filters = $this->updateParamsFilters($params);
        if ($filters) {
            $newParams['filters'] = $filters;
        }

        $newParams['order'] = $this->updateParamsOrder($params);

        $newParams['pagination'] = $this->updateParamsPagination($params);

        return $newParams;
    }

    /**
     * Remove non-existing/incorrect filters from params
     *
     * @param array $params
     * @return array|null
     */
    public function updateParamsFilters(array $params): array|null
    {
        $newFilters = [];
        $conditions = ['=', '<', '>', '!=', '<>', 'LIKE'];

        $filters = $this->getParamsItem($params, 'filters');

        if (!$filters) {
            return null;
        }

        foreach ($filters as &$filter) {
            if (!array_key_exists('field', $filter) || !array_key_exists('value', $filter)) {
                continue;
            }

            if ($this->isFromModel($filter['field'])) {
                if (!Schema::hasColumn($this->model->getTable(), $filter['field'])) {
                    continue;
                }
            } else {
                $relation = $this->getRelationName($filter['field']);
                if (!$this->relationExists($this->model::class, $relation)) {
                    continue;
                }
            }

            if (array_key_exists('type', $filter)) {
                if (!in_array($filter['type'], $conditions)) {
                    continue;
                }

                if ($filter['type'] === 'LIKE' && !str_contains($filter['value'], '%')) {
                    $filter['value'] = '%' . $filter['value'] . '%';
                }
            }

            $newFilters[] = $filter;
        }

        if (count($newFilters)) {
            return $newFilters;
        }

        return null;
    }

    /**
     * Reset orderBy in case of incorrect values
     *
     * @param array $params
     * @return array|null
     */
    public function updateParamsOrder(array $params): array|null
    {
        $order = $this->getParamsItem($params, 'order');
        $types = ['ASC', 'DESC'];

        if (!$order ||
            !array_key_exists('field', $order) ||
            !array_key_exists('type', $order) ||
            !in_array(strtoupper($order['type']), $types) ||
            !Schema::hasColumn($this->model->getTable(), $order['field'])
        ) {
            return $this->defaultOrder;
        }

        return $order;
    }

    /**
     * Change params pagination in case of incorrect values
     *
     * @param array $params
     * @return array|null
     */
    public function updateParamsPagination(array $params): array|null
    {
        $pagination = $this->getParamsItem($params, 'pagination');

        if (!$pagination ||
            !array_key_exists('offset', $pagination) ||
            !array_key_exists('limit', $pagination) ||
            !is_int($pagination['offset']) ||
            !is_int($pagination['limit'])
        ) {
            return ['offset' => 0, 'limit' => intval(env('PAGINATION_LIMIT', 15))];
        }

        return $pagination;
    }

    /**
     * Generate query builder based on params array
     *
     * @param Builder $query
     * @param array $params
     * @param bool $onlyCount
     * @return Builder
     */
    public function generate(Builder $query, array $params, bool $onlyCount = false): Builder
    {
        $params = $this->updateParams($params);
        $query = $this->addFilters($query, $params);

        if (!$onlyCount) {
            $query = $this->addOrder($query, $params);
            $query = $this->addPagination($query, $params);
        }

        return $query;
    }

    /**
     * Add filters to query builder
     *
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function addFilters(Builder $query, array $params): Builder
    {
        $filters = $this->getParamsItem($params, 'filters');
        if ($filters) {
            foreach ($filters as $filter) {
                $condition = $this->conditionType($filter);

                if ($this->isFromModel($filter['field'])) {
                    $query->where($filter['field'], $condition, $filter['value']);
                } else {
                    $relation = $this->getRelationName($filter['field']);
                    $replacedRelationField = $this->replaceRelationAlias($this->model::class, $filter['field']);

                    $query->whereHas($relation, function ($query) use ($filter, $condition, $replacedRelationField) {
                        $query->where($replacedRelationField, $condition, $filter['value']);
                    });
                }
            }
        }

        return $query;
    }

    /**
     * Add orderBy to query builder
     *
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function addOrder(Builder $query, array $params): Builder
    {
        $order = $this->getParamsItem($params, 'order');
        if ($order) {
            $query->orderBy($order['field'], $order['type']);
        }

        return $query;
    }

    /**
     * Add offset/limit to query builder
     *
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function addPagination(Builder $query, array $params): Builder
    {
        $pagination = $this->getParamsItem($params, 'pagination');
        if ($pagination) {
            $query->offset($pagination['offset'])
                ->limit($pagination['limit']);
        }

        return $query;
    }
}
