<?php

namespace App\Dto\Travel;

use Symfony\Component\Validator\Constraints as Assert;

class CalculateDto
{
    public function __construct(
        #[Assert\NotBlank]
        public string $birthdayDate,
        #[Assert\NotBlank]
        public float $basePrice,
        public string|null $travelStartDate,
        public string|null $travelPaymentDate,
    ) {
    }
}
