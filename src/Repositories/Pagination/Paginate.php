<?php

namespace ATP\Repositories\Pagination;

class Paginate {
    const PAGE_PARAM = "page";
    CONST LIMIT_PARAM = "limit";
    CONST SORT_BY_PARAM = "sortBy";
    CONST SORT_ORDER_PARAM = "sortOrder";


    const DEFAULT_PAGE = 1;
    const DEFAULT_LIMIT = 10;
    const DEFAULT_PAGE_SIZE = 10;
    const DEFAULT_SORT_BY = 'id';
    CONST DEFAULT_SORT_ORDER = 'ASC';

    public int $page;

    public int $limit;

    public string $sortBy;

    public string $sortOrder;

    public function __construct(int $page, int $limit, string $sortBy, string $sortOrder) {
        $this->page = $page;
        $this->limit = $limit;
        $this->sortBy = $sortBy;
        $this->sortOrder = $sortOrder;
    }

    public function getPage() {
        return $this->page;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function getSortBy() {
        return $this->sortBy;
    }

    public function getSortOrder() {
        return $this->sortOrder;
    }
}