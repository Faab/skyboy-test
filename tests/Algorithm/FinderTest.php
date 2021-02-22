<?php

namespace Eurecab\FinderTest\Algorithm;

use Eurecab\Finder\Algorithm\Finder;
use Eurecab\Finder\Algorithm\FinderType;
use Eurecab\Finder\Algorithm\Person;
use PHPUnit\Framework\TestCase;

final class FinderTest extends TestCase
{
    /** @var Person */
    private $sue;

    /** @var Person */
    private $greg;

    /** @var Person */
    private $sarah;

    /** @var Person */
    private $mike;

    protected function setUp(): void
    {
        $this->sue            = new Person();
        $this->sue->name      = "Sue";
        $this->sue->birthDate = new \DateTime("1950-01-01");

        $this->greg            = new Person();
        $this->greg->name      = "Greg";
        $this->greg->birthDate = new \DateTime("1952-05-01");

        $this->sarah            = new Person();
        $this->sarah->name      = "Sarah";
        $this->sarah->birthDate = new \DateTime("1982-01-01");

        $this->mike            = new Person();
        $this->mike->name      = "Mike";
        $this->mike->birthDate = new \DateTime("1979-01-01");
    }

    /** @test */
    public function should_return_empty_when_given_empty_list(): void
    {
        $list   = [];
        $finder = new Finder($list);

        $result = $finder->find(FinderType::CLOSTEST);

        self::assertEquals(null, $result->firstPerson);
        self::assertEquals(null, $result->secondPerson);
    }

    /** @test */
    public function should_return_empty_when_given_one_person(): void
    {
        $list   = [];
        $list[] = $this->sue;
        $finder = new Finder($list);

        $result = $finder->find(FinderType::CLOSTEST);

        self::assertEquals(null, $result->firstPerson);
        self::assertEquals(null, $result->secondPerson);
    }

    /** @test */
    public function should_return_closest_two_for_two_people(): void
    {
        $list   = [];
        $list[] = $this->sue;
        $list[] = $this->greg;
        $finder = new Finder($list);

        $result = $finder->find(FinderType::CLOSTEST);

        self::assertEquals($this->sue, $result->firstPerson);
        self::assertEquals($this->greg, $result->secondPerson);
    }

    /** @test */
    public function should_return_furthest_two_for_two_people(): void
    {
        $list   = [];
        $list[] = $this->mike;
        $list[] = $this->greg;
        $finder = new Finder($list);

        $result = $finder->find(FinderType::FURTHEST);

        self::assertEquals($this->greg, $result->firstPerson);
        self::assertEquals($this->mike, $result->secondPerson);
    }

    /** @test */
    public function should_return_furthest_two_for_four_people(): void
    {
        $list   = [];
        $list[] = $this->sue;
        $list[] = $this->sarah;
        $list[] = $this->mike;
        $list[] = $this->greg;
        $finder = new Finder($list);

        $result = $finder->find(FinderType::FURTHEST);

        self::assertEquals($this->sue, $result->firstPerson);
        self::assertEquals($this->sarah, $result->secondPerson);
    }

    /**
     * @test
     */
    public function should_return_closest_two_for_four_people(): void
    {
        $list   = [];
        $list[] = $this->sue;
        $list[] = $this->sarah;
        $list[] = $this->mike;
        $list[] = $this->greg;
        $finder = new Finder($list);

        $result = $finder->find(FinderType::CLOSTEST);

        self::assertEquals($this->sue, $result->firstPerson);
        self::assertEquals($this->greg, $result->secondPerson);
    }
}