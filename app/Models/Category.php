<?php

namespace App\Models;

use App\Models\Relations\BelongsToManyByPath;
use App\Models\Relations\HasCustomRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, HasCustomRelationships, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'parent_id',
        'path',
    ];

    /**
     * Disabling timestamp columns
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['parent', 'allProducts'];

    /**
     * Category self relation
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'products_categories');
    }

    /**
     * @return BelongsToManyByPath
     */
    public function allProducts(): BelongsToManyByPath
    {
        return $this->belongsToManyByPath(Product::class, 'products_categories', 'categories');
    }
}
