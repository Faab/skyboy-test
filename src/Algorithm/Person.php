<?php

namespace Eurecab\Finder\Algorithm;

use DateTime;

final class Person
{
    /** @var string */
    public $name;

    /** @var DateTime */
    public $birthDate;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getBirthDate(): DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(DateTime $birthDate): void
    {
        $this->birthDate = $birthDate;
    }
}