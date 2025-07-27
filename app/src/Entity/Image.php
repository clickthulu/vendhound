<?php

namespace App\Entity;

use App\Enumerations\ImageUsageType;
use App\Repository\ImageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $name = null;

    #[ORM\Column(length: 1000)]
    private ?string $path = null;

    #[ORM\Column]
    private ?int $dimensionX = null;

    #[ORM\Column]
    private ?int $dimensionY = null;

    #[ORM\Column]
    private ?int $size = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $UploadedBy = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Dealership $AssocDealership = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true, enumType: ImageUsageType::class)]
    private ?array $UsageType = null;

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

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function getDimensionX(): ?int
    {
        return $this->dimensionX;
    }

    public function setDimensionX(int $dimensionX): static
    {
        $this->dimensionX = $dimensionX;

        return $this;
    }

    public function getDimensionY(): ?int
    {
        return $this->dimensionY;
    }

    public function setDimensionY(int $dimensionY): static
    {
        $this->dimensionY = $dimensionY;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getUploadedBy(): ?User
    {
        return $this->UploadedBy;
    }

    public function setUploadedBy(?User $UploadedBy): static
    {
        $this->UploadedBy = $UploadedBy;

        return $this;
    }

    public function getAssocDealership(): ?Dealership
    {
        return $this->AssocDealership;
    }

    public function setAssocDealership(?Dealership $AssocDealership): static
    {
        $this->AssocDealership = $AssocDealership;

        return $this;
    }

    /**
     * @return ImageUsageType[]|null
     */
    public function getUsageType(): ?array
    {
        return $this->UsageType;
    }

    public function setUsageType(?array $UsageType): static
    {
        $this->UsageType = $UsageType;

        return $this;
    }
}
