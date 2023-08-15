<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'item_id',
        'path',
    ];

    public $timestamps = false;

    /**
     * image->product relation
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'item_id', 'id');
    }

    /**
     * path column mutator
     *
     * @return Attribute
     */
    protected function path(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => '/' . env('IMAGE_STORAGE', 'storage') . $value,
        );
    }
}
