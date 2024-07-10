<?php

namespace App\Entity\Factory;

use App\Entity\Maze;
use App\Entity\Point;
use App\Entity\PointType;
use Doctrine\Persistence\ObjectRepository;

class PointFactory
{
    private $pointTypeRepository;

    public function __construct(ObjectRepository $pointTypeRepository)
    {
        $this->pointTypeRepository = $pointTypeRepository;
    }

    public function createFromConfigurationArray(Maze $maze, array $pointsConfiguration): Point
    {
        $coordinateString = array_keys($pointsConfiguration)[0];
        list($x, $y) = explode("_", $coordinateString, 2);

        return (new Point())
            ->setMaze($maze)
            ->setX($x)
            ->setY($y)
            ->setType($this->pointTypeRepository->find(array_values($pointsConfiguration)[0]))
        ;
    }
}