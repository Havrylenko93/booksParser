<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    /** @var string[]  */
    protected $fillable = [
        'title',
        'isbn',
        'count_of_pages',
        'published_date',
        'thumbnail_url',
        'short_description',
        'long_description',
        'status',
    ];

    /** @var string[]  */
    protected $hidden = [
        'pivot'
    ];

    /**
     * @return BelongsToMany
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'books_authors');
    }

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'books_categories');
    }
}
