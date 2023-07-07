<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filter extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'filters';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'attr_1',
        'attr_2',
        'filter_group_id',
    ];

    /**
     * Disabling timestamp columns
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Filter -> Filter Group relation
     *
     * @return BelongsTo
     */
    public function filterGroup(): BelongsTo
    {
        return $this->belongsTo(FilterGroup::class, 'filter_group_id', 'id');
    }
}
