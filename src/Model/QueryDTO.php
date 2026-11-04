<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class QueryDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $message = "Hey this is my default value!",
    ) {}
}