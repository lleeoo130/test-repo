<?php

namespace App\Entity\Factory;

use App\Entity\Maze;
use App\Entity\Point;

class PointFactory
{
    public function createFromConfigurationArray(Maze $maze, array $configuration): Point
    {
        $coordinateString = array_keys($configuration)[0];
        list($x, $y) = explode("_", $coordinateString, 2);

        return (new Point())
            ->setMaze($maze)
            ->setX($x)
            ->setY($y)
            ->setType($configuration[$coordinateString])
        ;
    }
}