<?php

namespace App\Entity;

use App\Repository\TableRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TableRepository::class)]
#[ORM\Table(name: '`table`')]
class Table
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $locationName = null;

    #[ORM\Column]
    private ?float $width = 0;

    #[ORM\Column]
    private ?float $depth = 0;

    #[ORM\Column]
    private ?float $posX = 0;

    #[ORM\Column]
    private ?float $posY = 0;

    #[ORM\Column]
    private ?bool $isEndcap = false;

    #[ORM\Column]
    private ?bool $isMature = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocationName(): ?string
    {
        return $this->locationName;
    }

    public function setLocationName(string $locationName): static
    {
        $this->locationName = $locationName;

        return $this;
    }

    public function getWidth(): ?float
    {
        return $this->width;
    }

    public function setWidth(float $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getDepth(): ?float
    {
        return $this->depth;
    }

    public function setDepth(float $depth): static
    {
        $this->depth = $depth;

        return $this;
    }

    public function getPosX(): ?float
    {
        return $this->posX;
    }

    public function setPosX(float $posX): static
    {
        $this->posX = $posX;

        return $this;
    }

    public function getPosY(): ?float
    {
        return $this->posY;
    }

    public function setPosY(float $posY): static
    {
        $this->posY = $posY;

        return $this;
    }

    public function isEndcap(): ?bool
    {
        return $this->isEndcap;
    }

    public function setIsEndcap(bool $isEndcap): static
    {
        $this->isEndcap = $isEndcap;

        return $this;
    }

    public function isMature(): ?bool
    {
        return $this->isMature;
    }

    public function setIsMature(bool $isMature): static
    {
        $this->isMature = $isMature;

        return $this;
    }
}
