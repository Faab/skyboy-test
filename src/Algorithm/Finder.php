<?php

namespace Eurecab\Finder\Algorithm;

final class Finder
{
    /** @var Person[] */
    private $people;

    public function __construct(array $people)
    {
        $this->people = $people;
    }

    public function find(string $type): Comparator
    {
        $comparator = new Comparator();

        if (count($this->people) < 2) {
            return $comparator;
        }

        // Order people by birthday asc
        uasort($this->people, static function(Person $a, Person $b) {
            return $a->getBirthDate()->getTimestamp() > $b->getBirthDate()->getTimestamp();
        });

        $comparator->firstPerson = current($this->people);

        switch ($type) {
            case FinderType::FURTHEST:
                $comparator->secondPerson = end($this->people);
                $comparator->delta = self::calculateDelta($comparator->firstPerson, $comparator->secondPerson);
                break;

            case FinderType::CLOSEST:
                $comparator->secondPerson = next($this->people);
                $comparator->delta = self::calculateDelta($comparator->firstPerson, $comparator->secondPerson);

                while (false !== $person = next($this->people)) {
                    if (($delta = self::calculateDelta($comparator->secondPerson, $person)) < $comparator->delta) {
                        $comparator->firstPerson  = $comparator->secondPerson;
                        $comparator->secondPerson = $person;
                        $comparator->delta = $delta;
                    }
                }
                break;

            default:
                throw new \RuntimeException('Invalid Finder Type');
        }

        return $comparator;
    }

    private static function calculateDelta(Person $firstPerson, Person $secondPerson): int
    {
        return $secondPerson->getBirthDate()->getTimestamp() - $firstPerson->getBirthDate()->getTimestamp();
    }
}
