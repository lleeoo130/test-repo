<?php

namespace App\Tests;

use App\Entity\Factory\PointFactory;
use App\Entity\Maze;
use App\Entity\Point;
use PHPUnit\Framework\TestCase;

class PointFactoryTest extends TestCase
{
    /**
     * @dataProvider configurationArrayProvider
     */
    public function testCreateFactory(
        array $configuration,
        int $expectX,
        int $expectY,
        string $expectedType
    ): void
    {
        $this->sut = new PointFactory();

        $maze = new Maze();

        $result = $this->sut->createFromConfigurationArray($maze, $configuration);

        $this->assertInstanceOf(Point::class, $result);

        $this->assertSame($maze, $result->getMaze());
        $this->assertSame($expectX, $result->getX());
        $this->assertSame($expectY, $result->getY());
        $this->assertSame($expectedType, $result->getType());

        $this->assertTrue(true);
    }

    public function configurationArrayProvider(): \Generator
    {
        yield '1x1 empty' => [['1_1' => 'empty'], 1, 1, 'empty'];
        yield '2x2 spawn' => [['2_2' => 'spawn'], 2, 2, 'spawn'];
    }
}
