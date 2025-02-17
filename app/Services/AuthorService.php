<?php

namespace App\Services;

use App\Models\Author;
use App\Services\Interfaces\AuthorServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class AuthorService implements AuthorServiceInterface
{
    /**
     * @param array $requestData
     * @return LengthAwarePaginator
     */
    public function paginatedList(array $requestData): LengthAwarePaginator
    {
        $authors = Author::query();

        if (!empty($requestData['name'])) {
            $authors = $authors->where('full_name', 'like', '%' . $requestData['name'] . '%');
        }

        return $authors->paginate($requestData['per_page'] ?? 10);
    }

    /**
     * @param Author $author
     * @return Author
     */
    public function books(Author $author): Author
    {
        $author = $author->whereId($author->id)->with(['books' => function ($query) {
            $query->with('authors');
        }]);

        return $author->first();
    }
}
