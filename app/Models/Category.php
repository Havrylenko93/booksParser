<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    /** @var string[]  */
    protected $fillable = [
        'name',
    ];

    /** @var string[]  */
    protected $hidden = [
        'pivot'
    ];

    /**
     * @return BelongsToMany
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'books_categories');
    }
}
