<?php

namespace App\Entity;

class Travel
{
    private User $user;

    private int $basePrice;

    private \DateTime $travelStartDate;

    private \DateTime $travelPaymentDate;

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBasePrice(): int
    {
        return $this->basePrice;
    }

    public function setBasePrice(int $basePrice): self
    {
        $this->basePrice = $basePrice;

        return $this;
    }

    public function getTravelStartDate(): \DateTime
    {
        return $this->travelStartDate;
    }

    public function setTravelStartDate(\DateTime $travelStartDate): self
    {
        $this->travelStartDate = $travelStartDate;

        return $this;
    }

    public function getTravelPaymentDate(): \DateTime
    {
        return $this->travelPaymentDate;
    }

    public function setTravelPaymentDate(\DateTime $travelPaymentDate): self
    {
        $this->travelPaymentDate = $travelPaymentDate;

        return $this;
    }
}
