<?php

namespace App\UseCase\Travel;

use App\Dto\Travel\CalculateDto;
use App\Dto\Travel\DiscountDto;
use App\Entity\Travel;
use App\Entity\User;
use App\Service\TravelService;

class Calculate
{
    public function __construct(private TravelService $travelService)
    {
    }

    public function handle(CalculateDto $dto): DiscountDto
    {
        $user = (new User())->setBirthdayDate(new \DateTime($dto->birthdayDate));

        $travel = (new Travel())
            ->setTravelPaymentDate(
                $dto->travelPaymentDate
                    ? new \DateTime($dto->travelPaymentDate)
                    : new \DateTime('now')
            )
            ->setTravelStartDate(
                $dto->travelStartDate
                    ? new \DateTime($dto->travelStartDate)
                    : new \DateTime('now')
            )
            ->setBasePrice($dto->basePrice)
            ->setUser($user)
        ;

        return (new DiscountDto($this->travelService->calculateWithDiscount($travel)));
    }
}
