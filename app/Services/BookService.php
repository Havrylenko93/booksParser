<?php

namespace App\Services;

use App\Models\Book;
use App\Services\Interfaces\BookServiceInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class BookService implements BookServiceInterface
{
    /**
     * @param array $requestData
     * @return LengthAwarePaginator
     */
    public function paginatedList(array $requestData): LengthAwarePaginator
    {
        $books = Book::query()->with(['authors', 'categories']);

        if (!empty($requestData['title'])) {
            $books = $books->where('title', 'like', '%' . $requestData['title'] . '%');
        }

        if (!empty($requestData['description'])) {
            $books = $books->where('short_description', 'like', '%' . $requestData['description'] . '%')
                ->orWhere('long_description', 'like', '%' . $requestData['description'] . '%');
        }

        if (!empty($requestData['author_id'])) {
            $books->whereHas('authors', function (Builder $query) use ($requestData) {
                $query->whereAuthorId($requestData['author_id']);
            });
        }

        return $books->paginate($requestData['per_page'] ?? 10);
    }
}
