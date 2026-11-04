<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class PaginationDTO
{
    public function __construct(
        #[Assert\Positive]
        public int $page = 1,

        #[Assert\Positive]
        public int $limit = 10,

        public ?string $title = null,

        public ?int $year = null,
    ) {
    }
}