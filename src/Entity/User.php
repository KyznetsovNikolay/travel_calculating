<?php

namespace App\Entity;

class User
{
    private \DateTime $birthdayDate;

    public function getBirthdayDate(): \DateTime
    {
        return $this->birthdayDate;
    }

    public function setBirthdayDate(\DateTime $birthdayDate): self
    {
        $this->birthdayDate = $birthdayDate;

        return $this;
    }
}
