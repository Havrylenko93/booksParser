<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\GetAuthorsRequest;
use App\Http\Requests\Api\V1\GetBooksRequest;
use App\Models\Author;
use App\Services\Interfaces\AuthorServiceInterface;
use App\Services\Interfaces\BookServiceInterface;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    /**
     * @param BookServiceInterface $bookService
     * @param AuthorServiceInterface $authorService
     */
    public function __construct(
        private readonly BookServiceInterface $bookService,
        private readonly AuthorServiceInterface $authorService,
    ) {
    }

    /**
     * @param GetBooksRequest $request
     * @return JsonResponse
     */
    public function getBooks(GetBooksRequest $request): JsonResponse
    {
        //TODO: use Resource
        return response()->json($this->bookService->paginatedList($request->validated()));
    }

    /**
     * @param GetAuthorsRequest $request
     * @return JsonResponse
     */
    public function getAuthors(GetAuthorsRequest $request): JsonResponse
    {
        return response()->json($this->authorService->paginatedList($request->validated()));
    }

    /**
     * @param Author $author
     * @return JsonResponse
     */
    public function getAuthorBooks(Author $author): JsonResponse
    {
        return response()->json($this->authorService->books($author));
    }
}
