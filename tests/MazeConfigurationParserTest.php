<?php

namespace App\Tests;

use App\Entity\Parser\MazeConfigurationParser;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;

class MazeConfigurationParserTest extends TestCase
{
    public function testSomething(): void
    {
        $this->sut = new MazeConfigurationParser();

        $bag = new ParameterBag();

        $bag->set('maze_configuration_1_1', 'spawn');
        $bag->set('maze_configuration_1_2', 'empty');
        $bag->set('maze_configuration_1_3', 'empty');
        $bag->set('maze_configuration_1_4', 'empty');

        $result = $this->sut->parse($bag);

        $this->assertSame([
            "1_1" => "spawn",
            "1_2" => "empty",
            "1_3" => "empty",
            "1_4" => "empty",
        ], $result);
    }
}
