<?php

namespace App\Entity;

use App\Repository\DealershipRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DealershipRepository::class)]
class Dealership
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $taxID = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $productsAndServices = null;

    #[ORM\ManyToOne(inversedBy: 'dealerships')]
    private ?TableType $tableRequestType = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'dealerships')]
    private Collection $categories;

    /**
     * @var Collection<int, Note>
     */
    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'dealership')]
    private Collection $notes;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private DateTime $created_on;

    public function __construct()
    {
        $this->created_on = new DateTime();
        $this->categories = new ArrayCollection();
        $this->notes = new ArrayCollection();
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

    public function getTaxid(): ?string
    {
        return $this->taxID;
    }

    public function setTaxid(?string $taxID): static
    {
        $this->taxID = $taxID;

        return $this;
    }

    public function getProductsAndServices(): ?string
    {
        return $this->productsAndServices;
    }

    public function setProductsAndServices(?string $productsAndServices): static
    {
        $this->productsAndServices = $productsAndServices;

        return $this;
    }

    public function getTableRequestType(): ?TableType
    {
        return $this->tableRequestType;
    }

    public function setTableRequestType(?TableType $tableRequestType): static
    {
        $this->tableRequestType = $tableRequestType;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): static
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setDealership($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getDealership() === $this) {
                $note->setDealership(null);
            }
        }

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedOn(): DateTime
    {
        return $this->created_on;
    }

    /**
     * @param DateTime $created_on
     */
    public function setCreatedOn(DateTime $created_on): static
    {
        $this->created_on = $created_on;
        return $this;
    }


}
