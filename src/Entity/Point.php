<?php

namespace App\Entity;

use App\Repository\PointRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PointRepository::class)]
class Point
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'points')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Maze $maze = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $x = null;

    #[ORM\Column]
    private ?int $y = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaze(): ?maze
    {
        return $this->maze;
    }

    public function setMaze(?maze $maze): static
    {
        $this->maze = $maze;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getX(): ?int
    {
        return $this->x;
    }

    public function setX(int $x): static
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): ?int
    {
        return $this->y;
    }

    public function setY(int $y): static
    {
        $this->y = $y;

        return $this;
    }
}
