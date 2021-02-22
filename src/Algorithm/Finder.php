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

    public function find(string $type): Comparator {
        /** @var Comparator[] $tr */
        $tr = [];

        for ($i = 0, $iMax = count($this->people); $i < $iMax; $i++) {
            for ($j = $i + 1, $jMax = count($this->people); $j < $jMax; $j++) {
                $r = new Comparator();

                if ($this->people[$i]->birthDate < $this->people[$j]->birthDate) {
                    $r->firstPerson = $this->people[$i];
                    $r->secondPerson = $this->people[$j];
                } else {
                    $r->firstPerson = $this->people[$j];
                    $r->secondPerson = $this->people[$i];
                }

                $r->delta = $r->secondPerson->birthDate->getTimestamp() - $r->firstPerson->birthDate->getTimestamp();

                $tr[] = $r;
            }
        }

        if (count($tr) < 1) {
            return new Comparator();
        }

        $answer = $tr[0];

        foreach ($tr as $result) {
            switch ($type) {
                case FinderType::CLOSTEST:
                    if ($result->delta < $answer->delta) {
                        $answer = $result;
                    }
                    break;

                case FinderType::FURTHEST:
                    if ($result->delta > $answer->delta) {
                        $answer = $result;
                    }
                    break;
            }
        }

        return $answer;
    }
}