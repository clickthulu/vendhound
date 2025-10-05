<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Dealership>
     */
    #[ORM\ManyToMany(targetEntity: Dealership::class, mappedBy: 'categories')]
    private Collection $dealerships;


    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private DateTime $createdOn;

    #[ORM\Column(length: 10)]
    private string $color;

    public function __construct()
    {
        $this->createdOn = new DateTime();
        $this->dealerships = new ArrayCollection();
        $this->color = $this->randomizeColor();
    }

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

    /**
     * @return Collection<int, Dealership>
     */
    public function getDealerships(): Collection
    {
        return $this->dealerships;
    }

    public function addDealership(Dealership $dealership): static
    {
        if (!$this->dealerships->contains($dealership)) {
            $this->dealerships->add($dealership);
            $dealership->addCategory($this);
        }

        return $this;
    }

    public function removeDealership(Dealership $dealership): static
    {
        if ($this->dealerships->removeElement($dealership)) {
            $dealership->removeCategory($this);
        }

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedOn(): DateTime
    {
        return $this->createdOn;
    }

    /**
     * @param DateTime|null $createdOn
     */
    public function setCreatedOn(DateTime $createdOn): static
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

        private function randomizeColor()
        {   $color = '#';
            for ($c = 0; $c < 3; $c++) {
                $hex = str_pad(dechex(rand(0,255)), '2', '0', STR_PAD_LEFT);
                $color .= $hex;
            }
            return $color;
        }
}
