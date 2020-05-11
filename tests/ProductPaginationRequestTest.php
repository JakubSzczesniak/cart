<?php

namespace App\Tests;

use App\Shared\Domain\Paginator;
use PHPUnit\Framework\TestCase;

/**
 * Class ProductPaginationRequestTest
 */
class ProductPaginationRequestTest extends TestCase
{
    /**
     * @dataProvider paginationData
     *
     * @param int $inputPage
     * @param int $limit
     * @param int $offset
     * @param int $page
     */
    public function testPagination($inputPage, int $limit, int $offset, int $page): void
    {
        $pagination = new Paginator($inputPage);
        $this->assertEquals($limit, $pagination->getLimit());
        $this->assertEquals($offset, $pagination->getOffset());
        $this->assertEquals($page, $pagination->getPageNumber());
    }

    /**
     * @return array
     */
    public function paginationData(): array
    {
        return [
            [1, 3, 0, 1],
            [0, 3, 0, 1],
            [-1, 3, 0, 1],
            [2, 3, 3, 2],
            [3, 3, 6, 3],
        ];
    }
}
