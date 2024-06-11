<?php

namespace App\Service;

use App\Entity\Travel;

class TravelService
{
    public function __construct(private DateService $dateService)
    {
    }

    public function calculateWithDiscount(Travel $travel): float
    {
        $discount = 0;
        $birthdayDate = $travel->getUser()->getBirthdayDate();

        if ($this->userIsChild($birthdayDate)) {
            $discount += $this->getChildDiscount($birthdayDate);
        }

        $earlyBookingDiscount = $this->getEarlyBookingDiscount($travel->getTravelPaymentDate(), $travel->getTravelStartDate());

        return $earlyBookingDiscount + $discount;
    }

    public function userIsChild(\DateTime $birthdayDate): bool
    {
        return $this->dateService->getYearDifference(new \DateTime(), $birthdayDate) <= 18;
    }

    public function getChildDiscount(\DateTime $birthdayDate): int
    {
        $age = $this->dateService->getYearDifference(new \DateTime(), $birthdayDate);

        return match(true) {
            $age >= 3 && $age < 6 => 80,
            $age >= 6 && $age < 12 => 30,
            $age >= 12 && $age <= 18 => 10
        };
    }

    public function getEarlyBookingDiscount(\DateTime $paymentDate, \DateTime $travelStartDate): int
    {
        $discount = 0;
        $startAprilThisYear = (new \DateTime())->setDate($travelStartDate->format('Y'), 4, 1);
        $startSeptemberNextYear = (new \DateTime())->setDate($this->dateService->modifyYear('+1')->format('Y'), 9, 30);
        $startBetweenAprilAndSeptember = $this->dateService->between($travelStartDate, $startAprilThisYear, $startSeptemberNextYear, 'Y-m-d');

        $paymentBeforeNovember = $paymentDate->format('Y-m-d') <= (new \DateTime())->setDate((new \DateTime('now'))->format('Y'), 11, 30)->format('Y-m-d');
        $paymentDecember = $this->dateService->between(
            $paymentDate,
            (new \DateTime())->setDate((new \DateTime('now'))->format('Y'), 12, 1),
            (new \DateTime())->setDate((new \DateTime('now'))->format('Y'), 12, 31),
            'Y-m-d'
        );

        $paymentJanuary = $this->dateService->between(
            $paymentDate,
            (new \DateTime())->setDate($this->dateService->modifyYear('+1')->format('Y'), 1, 1),
            (new \DateTime())->setDate($this->dateService->modifyYear('+1')->format('Y'), 1, 31),
            'm-d-Y'
        );

        $startOctoberThisYear = (new \DateTime())->setDate($travelStartDate->format('Y'), 10, 1);
        $startJanuaryNextYear = (new \DateTime())->setDate($this->dateService->modifyYear('+1')->format('Y'), 1, 14);
        $startBetweenOctoberAndJanuary = $this->dateService->between($travelStartDate, $startOctoberThisYear, $startJanuaryNextYear, 'Y-m-d');

        $paymentAllMarchAndBefore = $paymentDate->format('Y-m-d') <= (new \DateTime())->setDate((new \DateTime('now'))->format('Y'), 3, 31)->format('Y-m-d');

        $paymentApril = $this->dateService->between(
            $paymentDate,
            (new \DateTime())->setDate((new \DateTime('now'))->format('Y'), 4, 1),
            (new \DateTime())->setDate((new \DateTime('now'))->format('Y'), 4, 30),
            'Y-m-d'
        );

        $paymentMay = $this->dateService->between(
            $paymentDate,
            (new \DateTime())->setDate((new \DateTime('now'))->format('Y'), 5, 1),
            (new \DateTime())->setDate((new \DateTime('now'))->format('Y'), 5, 31),
            'Y-m-d'
        );

        $startFromJanuaryNextYear = $travelStartDate->format('Y-m-d') >= (new \DateTime())->setDate($this->dateService->modifyYear('+1')->format('Y'), 1, 15)->format('Y-m-d');
        $paymentAugustAndEarly = $paymentDate->format('Y-m-d') <= (new \DateTime())->setDate((new \DateTime('now'))->format('Y'), 8, 31)->format('Y-m-d');
        $paymentSeptember = $this->dateService->between(
            $paymentDate,
            (new \DateTime())->setDate((new \DateTime('now'))->format('Y'), 9, 1),
            (new \DateTime())->setDate((new \DateTime('now'))->format('Y'), 9, 30),
            'Y-m-d'
        );

        $paymentOctober = $this->dateService->between(
            $paymentDate,
            (new \DateTime())->setDate((new \DateTime('now'))->format('Y'), 10, 1),
            (new \DateTime())->setDate((new \DateTime('now'))->format('Y'), 10, 31),
            'Y-m-d'
        );

        switch (true) {
            case $startBetweenAprilAndSeptember && $paymentBeforeNovember && !$startBetweenOctoberAndJanuary
                || $startBetweenOctoberAndJanuary && $paymentAllMarchAndBefore
                || $startFromJanuaryNextYear && $paymentAugustAndEarly:
                $discount = 7;
                break;
            case $startBetweenAprilAndSeptember && $paymentDecember && !$startBetweenOctoberAndJanuary
                || $startBetweenOctoberAndJanuary && $paymentApril
                || $startFromJanuaryNextYear && $paymentSeptember:
                $discount = 5;
                break;
            case $startBetweenAprilAndSeptember && $paymentJanuary && !$startBetweenOctoberAndJanuary
                || $startBetweenOctoberAndJanuary && $paymentMay
                || $startFromJanuaryNextYear && $paymentOctober:
                $discount = 3;
                break;
        }

        return $discount;
    }
}
