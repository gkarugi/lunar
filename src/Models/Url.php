<?php

namespace GetCandy\Models;

use GetCandy\Base\BaseModel;
use GetCandy\Database\Factories\UrlFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Url extends BaseModel
{
    use HasFactory;

    /**
     * Return a new factory instance for the model.
     *
     * @return \GetCandy\Database\Factories\UrlFactory
     */
    protected static function newFactory(): UrlFactory
    {
        return UrlFactory::new();
    }

    /**
     * Define which attributes should be
     * protected from mass assignment.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Define attribute casting.
     *
     * @var array
     */
    protected $casts = [
        'default' => 'boolean',
    ];

    /**
     * Return the elements relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function elements()
    {
        return $this->morphTo();
    }

    /**
     * Return the language relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}