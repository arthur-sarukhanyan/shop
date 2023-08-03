<?php

namespace App\Models\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class BelongsToManyByPath extends BelongsToMany
{
    protected $conditionKey;

    protected $pathTable;

    public const PATH_TABLE_ALIAS = 'pta';

    public function __construct(Builder $query, Model $parent, $table, $pathTable, $foreignPivotKey,
                                        $relatedPivotKey, $parentKey, $relatedKey, $relationName = null)
    {
        $this->pathTable = $pathTable;

        parent::__construct($query, $parent, $table, $foreignPivotKey,
            $relatedPivotKey, $parentKey, $relatedKey, $relationName);
    }

    protected function performJoin($query = null)
    {
        $query = $query ?: $this->query;

        $query->join(
            $this->table,
            $this->getQualifiedRelatedKeyName(),
            '=',
            $this->getQualifiedRelatedPivotKeyName()
        )->join(
            DB::raw($this->pathTable . ' ' . self::PATH_TABLE_ALIAS),
            $this->pathTable . '.path',
            'LIKE',
            DB::raw("CONCAT('%|', " . self::PATH_TABLE_ALIAS . ".id, '|%')")
        );

        return $this;
    }

    public function match(array $models, Collection $results, $relation)
    {
        $this->conditionKey = $this->getKeys($models, $this->parentKey)[0];
        $dictionary = $this->buildDictionary($results);

        foreach ($models as $model) {
            $key = $this->getDictionaryKey($model->{$this->parentKey});

            if (isset($dictionary[$key])) {
                $model->setRelation(
                    $relation, $this->related->newCollection($dictionary[$key])
                );
            }
        }

        return $models;
    }

    protected function buildDictionary(Collection $results): array
    {
        $dictionary = [];

        foreach ($results as $result) {
            $dictionary[$this->conditionKey][] = $result;
        }

        return $dictionary;
    }
}
