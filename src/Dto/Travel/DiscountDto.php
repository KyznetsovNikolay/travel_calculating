<?php

namespace App\Dto\Travel;

use Symfony\Component\Validator\Constraints as Assert;

class DiscountDto
{
    public function __construct(
        #[Assert\NotBlank]
        private int $discount,
    ) {
    }

    public function getDiscount(): int
    {
        return $this->discount;
    }
}
