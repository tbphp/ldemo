<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;

class ApiPaginator extends LengthAwarePaginator
{
    public function __construct($items, $total, $perPage, $currentPage = null, array $options = [])
    {
        parent::__construct($items, $total, $perPage, $currentPage, $options);
    }

    /**
     * 设置总数
     * @param int $total
     * @return $this
     */
    public function setTotal(int $total)
    {
        $this->total = $total;
        $this->lastPage = max((int) ceil($total / $this->perPage()), 1);

        return $this;
    }

    /**
     * 设置每页数量
     * @param int $perPage
     * @return $this
     */
    public function setPerPage(int $perPage)
    {
        $this->perPage = $perPage;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'list' => $this->items->toArray(),
            'count' => $this->total(),
            'current_page' => $this->currentPage(),
            'per_page' => $this->perPage(),
            'last_page' => $this->lastPage(),
            'from' => $this->firstItem(),
            'to' => $this->lastItem(),
        ];
    }
}
