<?php

namespace App\Service;

class DateService
{
    public function toYearFormat(\DateTime $dateTime): string
    {
        return $dateTime->format('Y');
    }

    public function getYearDifference(\DateTime $yearFrom, \DateTime $yearTo): int
    {
        return $this->toYearFormat($yearFrom) - $this->toYearFormat($yearTo);
    }

    public function modifyYear(string $count): \DateTime
    {
        return $this->modify(new \DateTime(), sprintf('%s year', $count));
    }

    public function modifyMonth(string $count): \DateTime
    {
        return $this->modify(new \DateTime(), sprintf('%s month', $count));
    }

    private function modify(\DateTime $date, string $modifier): \DateTime
    {
        return $date->modify($modifier);
    }

    public function between(\DateTime $checkedDate, \DateTime $fromDate, \DateTime $toDate, string $format = 'd-m-Y'): bool
    {
        return ($checkedDate->format($format) >= $fromDate->format($format))
            && ($checkedDate->format($format) <= $toDate->format($format));
    }
}
