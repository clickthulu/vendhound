<?php /** @noinspection PhpUnused */

namespace App\Entity;

use App\Repository\TableTypeRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TableTypeRepository::class)]
class TableType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $width = 0;

    #[ORM\Column]
    private ?float $depth = 0;

    /**
     * @var Collection<int, Dealership>
     */
    #[ORM\OneToMany(targetEntity: Dealership::class, mappedBy: 'tableRequestType')]
    private Collection $dealerships;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private DateTime $createdon;

    public function __construct()
    {
        $this->createdon = new DateTime();
        $this->dealerships = new ArrayCollection();
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
            $dealership->setTableRequestType($this);
        }

        return $this;
    }

    public function removeDealership(Dealership $dealership): static
    {
        if ($this->dealerships->removeElement($dealership)) {
            // set the owning side to null (unless already changed)
            if ($dealership->getTableRequestType() === $this) {
                $dealership->setTableRequestType(null);
            }
        }

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedon(): DateTime
    {
        return $this->createdon;
    }

    /**
     * @param DateTime $createdon
     * @return TableType
     */
    public function setCreatedon(DateTime $createdon): static
    {
        $this->createdon = $createdon;
        return $this;
    }



}
