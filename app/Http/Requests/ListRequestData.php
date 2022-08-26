<?php

declare(strict_types=1);

namespace App\Http\Requests;

/**
 * Query params DTO class
 */
class ListRequestData
{
    private const DEFAULT_PAGE = 1;
    private const DEFAULT_PER_PAGE = 10;

    private ?int $page;
    private ?int $perPage;

    public function __construct(?int $page, ?int $perPage)
    {
        $this->page = $page ?? self::DEFAULT_PAGE;
        $this->perPage = $perPage ?? self::DEFAULT_PER_PAGE;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }
}
