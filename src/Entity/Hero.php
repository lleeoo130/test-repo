<?php

namespace App\Entity;

use App\Repository\HeroRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HeroRepository::class)]
class Hero
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $level = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Point $currentPoint = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getCurrentPoint(): ?Point
    {
        return $this->currentPoint;
    }

    public function setCurrentPoint(?Point $currentPoint): static
    {
        $this->currentPoint = $currentPoint;

        return $this;
    }

    public function canMoveToPoint(Point $point): bool
    {
        return $this->currentPoint !== $point &&
            ( $this->currentPoint->getX() - $point->getX() === 0 ||
            $this->currentPoint->getX() - $point->getX() === 1 ||
            $this->currentPoint->getX() - $point->getX() === -1 ) &&
            ( $this->currentPoint->getY() - $point->getY() === 0 ||
                $this->currentPoint->getY() - $point->getY() === 1 ||
                $this->currentPoint->getY() - $point->getY() === -1 )
        ;
    }
}
