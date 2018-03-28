<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 28/03/18
 * Time: 09:34
 */

namespace App\Tests\Game;


use App\Game\Game;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class GameTest extends TestCase
{
    public function provideTryLetter()
    {
        return [
            ['symfony', 'a', FALSE],
            ['symfony', 's', TRUE],
            ['symfony', 'Y', TRUE],
        ];
    }

    /**
     * @dataProvider provideTryLetter
     */
    public function testTryLetter($word, $letter, $expected)
    {
        $game = new Game($word);

        $this->assertEquals(
            $expected,
            $game->tryLetter($letter)
        );
    }

    /**
     * @expectedException
     */
    public function testTryLetterException()
    {
        $game = new Game('symfony');
        $this->expectException(
            \InvalidArgumentException::class
        );
        $game->tryLetter(1);
    }

    public function testTryLetterDuplicate()
    {
        $game = new Game('symfony');
        $game->tryLetter('f');
        $this->assertEquals(
            FALSE,
            $game->tryLetter('f')
        );
    }
}