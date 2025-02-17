<?php

namespace App\Services\Interfaces;

use App\Models\Author;
use Illuminate\Pagination\LengthAwarePaginator;

interface AuthorServiceInterface
{
    /**
     * @param array $requestData
     * @return LengthAwarePaginator
     */
    public function paginatedList(array $requestData): LengthAwarePaginator;

    /**
     * @param Author $author
     * @return Author
     */
    public function books(Author $author): Author;
}
