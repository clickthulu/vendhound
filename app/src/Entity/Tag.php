<?php

namespace App\Entity;

use App\Repository\TagRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Table>
     */
    #[ORM\ManyToMany(targetEntity: Table::class, mappedBy: 'tags')]
    private Collection $tables;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private DateTime $createdOn;

    public function __construct()
    {
        $this->createdOn = new DateTime();
        $this->tables = new ArrayCollection();
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
     * @return Collection<int, Table>
     */
    public function getTables(): Collection
    {
        return $this->tables;
    }

    public function addTable(Table $table): static
    {
        if (!$this->tables->contains($table)) {
            $this->tables->add($table);
            $table->addTag($this);
        }

        return $this;
    }

    public function removeTable(Table $table): static
    {
        if ($this->tables->removeElement($table)) {
            $table->removeTag($this);
        }

        return $this;
    }

    public function getCreatedOn(): ?DateTime
    {
        return $this->createdOn;
    }

    public function setCreatedOn(DateTime $createdOn): static
    {
        $this->createdOn = $createdOn;

        return $this;
    }
}
