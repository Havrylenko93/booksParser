<?php

namespace App\Services\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface BookServiceInterface
{
    /**
     * @param array $requestData
     * @return LengthAwarePaginator
     */
    public function paginatedList(array $requestData): LengthAwarePaginator;
}
