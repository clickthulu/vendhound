<?php

namespace App\Entity;

use App\Repository\TableRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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


    /**
     * @var Collection<int, Tag>
     */
    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'tables')]
    private Collection $tags;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private DateTime $created_on;

    public function __construct()
    {
        $this->created_on = new DateTime();
        $this->tags = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getCreatedOn(): ?DateTime
    {
        return $this->created_on;
    }

    public function setCreatedOn(DateTime $created_on): static
    {
        $this->created_on = $created_on;

        return $this;
    }
}
