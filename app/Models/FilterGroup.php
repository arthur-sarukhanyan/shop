<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FilterGroup extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'filter_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Disabling timestamp columns
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Filter Group -> Filter relation
     *
     * @return HasMany
     */
    public function filters(): HasMany
    {
        return $this->hasMany(Filter::class, 'filter_group_id', 'id');
    }
}
