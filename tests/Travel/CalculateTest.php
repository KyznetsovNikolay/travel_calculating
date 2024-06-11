<?php

namespace App\Tests\Travel;

use App\Entity\Travel;
use App\Entity\User;
use App\Service\TravelService;
use PHPUnit\Framework\TestCase;

class CalculateTest extends TestCase
{
    public function testGetChildDiscount()
    {
        $birthdayDate = (new \DateTime())->setDate('2020', '1', '1');

        $travelService = $this->createMock(TravelService::class);
        $travelService
            ->expects($this->once())
            ->method('getChildDiscount')
            ->with($birthdayDate)
            ->will($this->returnValue($discount = 80));

        $this->assertEquals($discount, $travelService->getChildDiscount($birthdayDate));
    }

    public function testGetEarlyBookingDiscount()
    {
        $paymentDate = (new \DateTime())->setDate((new \DateTime('now'))->format('Y'), 11, 29);
        $travelDate = (new \DateTime())->setDate((new \DateTime('now'))->format('Y'), 5, 1);
        $travelService = $this->createMock(TravelService::class);
        $travelService
            ->expects($this->once())
            ->method('getEarlyBookingDiscount')
            ->with($paymentDate, $travelDate)
            ->will($this->returnValue($discount = 7));

        $this->assertEquals($discount, $travelService->getEarlyBookingDiscount($paymentDate, $travelDate));
    }

    public function testCalculateWithDiscount()
    {
        $travel = (new Travel())
            ->setBasePrice(10000)
            ->setTravelPaymentDate(new \DateTime('29-11-2024'))
            ->setTravelStartDate(new \DateTime('01-05-2024'))
            ->setUser((new User())->setBirthdayDate(new \DateTime('01-01-1995')));

        $travelService = $this->createMock(TravelService::class);
        $travelService
            ->expects($this->once())
            ->method('calculateWithDiscount')
            ->with($travel)
            ->will($this->returnValue($discount = 7));

        $this->assertEquals($discount, $travelService->calculateWithDiscount($travel));
    }
}