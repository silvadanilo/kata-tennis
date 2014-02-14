<?php

require_once 'PlayerTest.php';
require_once 'PlayerInterface.php';

class GameTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->playerA = $this->getMock('PlayerInterface');
        $this->playerB = $this->getMock('PlayerInterface');
        $this->game = new Game($this->playerA, $this->playerB);
    }

    public function testThatScoreIs00AtTheBeginningOfTheGame()
    {
        $this->playerA->expects($this->once())
            ->method('nPoints')
            ->will($this->returnValue(0));

        $this->playerB->expects($this->once())
            ->method('nPoints')
            ->will($this->returnValue(0));

        $this->assertEquals("0 - 0", $this->game->formatScore());
    }

    public function testFirstPointByFirstPlayer()
    {
        $this->playerA->expects($this->once())
            ->method('nPoints')
            ->will($this->returnValue(1));

        $this->playerB->expects($this->once())
            ->method('nPoints')
            ->will($this->returnValue(0));

        $this->assertEquals("15 - 0", $this->game->formatScore());
    }

    public function testFirstPointBySecondPlayer()
    {
        $this->playerA->expects($this->once())
            ->method('nPoints')
            ->will($this->returnValue(0));

        $this->playerB->expects($this->once())
            ->method('nPoints')
            ->will($this->returnValue(1));

        $this->assertEquals("0 - 15", $this->game->formatScore());
    }

    public function testDeuce()
    {
        $this->playerA->expects($this->once())
            ->method('nPoints')
            ->will($this->returnValue(3));

        $this->playerB->expects($this->once())
            ->method('nPoints')
            ->will($this->returnValue(3));

        $this->assertEquals("40 - 40", $this->game->formatScore());
    }

    public function testAdvantageOfPlayerA()
    {
        $this->playerA->expects($this->once())
            ->method('nPoints')
            ->will($this->returnValue(4));

        $this->playerB->expects($this->once())
            ->method('nPoints')
            ->will($this->returnValue(3));

        $this->assertEquals("A - 40", $this->game->formatScore());
    }
}

class Game
{
    private $playerA;
    private $playerB;

    private $scores = [
        0,
        15,
        30,
        40,
    ];

    public function __construct(PlayerInterface $a, PlayerInterface $b)
    {
        $this->playerA = $a;
        $this->playerB = $b;
    }

    public function point(Player $scorer)
    {
        $scorer->point();
    }

    public function formatScore()
    {
        $pa = $this->playerA->nPoints();
        $pb = $this->playerB->nPoints();

        return $this->score($pa, $pb) . " - " . $this->score($pb, $pa);
    }

    private function score($nPoints, $otherPlayerNPoints)
    {
        if ($nPoints > 3) {
            if ($nPoints == $otherPlayerNPoints + 1) { //FIXME:! Remove annidation
                return 'A';
            }
        }

        return $this->scores[$nPoints];
    }
}
