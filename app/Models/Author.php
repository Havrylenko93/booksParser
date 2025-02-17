<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    /** @var string[]  */
    protected $fillable = [
        'full_name',
    ];

    /** @var string[]  */
    protected $appends = [
        'books_count',
    ];

    /** @var string[]  */
    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at',
    ];

    /**
     * @return BelongsToMany
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'books_authors');
    }

    /**
     * @return int
     */
    public function getBooksCountAttribute(): int
    {
        return $this->books()->count();
    }
}
