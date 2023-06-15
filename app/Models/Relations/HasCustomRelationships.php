<?php

namespace App\Models\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasCustomRelationships
{
    /**
     * Define a many-to-many relationship.
     *
     * @param  string  $related
     * @param  string|null  $table
     * @param  string|null  $pathTable
     * @param  string|null  $foreignPivotKey
     * @param  string|null  $relatedPivotKey
     * @param  string|null  $parentKey
     * @param  string|null  $relatedKey
     * @param  string|null  $relation
     * @return BelongsToManyByPath
     */
    public function belongsToManyByPath($related, $table = null, $pathTable = null, $foreignPivotKey = null, $relatedPivotKey = null,
                                  $parentKey = null, $relatedKey = null, $relation = null)
    {
        $instance = $this->newRelatedInstance($related);

        $foreignPivotKey = $foreignPivotKey ?: $this->getForeignKey();

        $relatedPivotKey = $relatedPivotKey ?: $instance->getForeignKey();

        if (is_null($table)) {
            $table = $this->joiningTable($related, $instance);
        }

        return $this->newBelongsToManyByPath(
            $instance->newQuery(), $this, $table, $pathTable, $foreignPivotKey,
            $relatedPivotKey, $parentKey ?: $this->getKeyName(),
            $relatedKey ?: $instance->getKeyName(), $relation
        );
    }

    protected function newRelatedInstance($class)
    {
        return tap(new $class, function ($instance) {
            if (! $instance->getConnectionName()) {
                $instance->setConnection($this->connection);
            }
        });
    }

    /**
     * Instantiate a new BelongsToManyByPath relationship.
     *
     * @param Builder $query
     * @param Model $parent
     * @param string $table
     * @param $pathTable
     * @param string $foreignPivotKey
     * @param string $relatedPivotKey
     * @param string $parentKey
     * @param string $relatedKey
     * @param null $relationName
     * @return BelongsToMany
     */
    protected function newBelongsToManyByPath(Builder $query, Model $parent, $table, $pathTable, $foreignPivotKey, $relatedPivotKey,
                                                $parentKey, $relatedKey, $relationName = null)
    {
        return new BelongsToManyByPath($query, $parent, $table, $pathTable, $foreignPivotKey, $relatedPivotKey, $parentKey, $relatedKey, $relationName);
    }
}
