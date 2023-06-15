<?php

namespace App\Models;

use App\Models\Relations\BelongsToManyByPath;
use App\Models\Relations\HasCustomRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory, HasCustomRelationships;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    public $pathTable = 'categories';

    public const ALIAS_RELATIONS = ['allCategories'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    protected $with = ['image'];

    /**
     * product->image relation
     *
     * @return HasOne
     */
    public function image(): HasOne
    {
        return $this->hasOne(Image::class, 'item_id', 'id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'products_categories');
    }

    public function allCategories(): BelongsToManyByPath
    {
        return $this->belongsToManyByPath(Category::class, 'products_categories', $this->pathTable);
    }
}
