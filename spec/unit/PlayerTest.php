<?php

require_once 'PlayerInterface.php';

class Player implements PlayerInterface
{
    private $name;
    private $nPoints;
    private $advantage;

    public function __construct($name)
    {
        $this->name = $name;
        $this->nPoints = 0;
        $this->advantage = false;
    }

    public function isEqual(PlayerInterface $matcher)
    {
        if ($matcher == $this) {
            return true;
        }

        return false;
    }

    public function point()
    {
        $this->nPoints++;
    }

    public function nPoints()
    {
        return $this->nPoints;
    }

    /* public function advantage() */
    /* { */
    /*     $this->advantage = true; */
    /* } */
}


class PlayerTest extends \PHPUnit_Framework_TestCase
{
    public function testScoreAtBeginningIsZero()
    {
        $player = new Player('PlayerA');
        $this->assertEquals(0, $player->nPoints());
    }

    public function testNPointsAfterSomePoint()
    {
        $player = new Player('PlayerA');
        $player->point();
        $player->point();
        $this->assertEquals(2, $player->nPoints());

    }

    public function testEqualsWithSamePlayerReturnsTrue()
    {
        $name = 'PlayerA';
        $player = new Player($name);

        $this->assertTrue($player->isEqual(new Player($name)));
    }

    public function testEqualsWithDifferentPlayerReturnsTrue()
    {
        $name = 'PlayerA';
        $player = new Player($name);

        $this->assertFalse($player->isEqual(new Player('fake-name')));
    }
}
