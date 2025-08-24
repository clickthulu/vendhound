<?php

namespace App\Entity;

use App\Repository\DealerAreaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DealerAreaRepository::class)]
class DealerArea
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, VoteEvent>
     */
    #[ORM\ManyToMany(targetEntity: VoteEvent::class, mappedBy: 'filterByArea')]
    private Collection $voteEvents;

    public function __construct()
    {
        $this->voteEvents = new ArrayCollection();
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
     * @return Collection<int, VoteEvent>
     */
    public function getVoteEvents(): Collection
    {
        return $this->voteEvents;
    }

    public function addVoteEvent(VoteEvent $voteEvent): static
    {
        if (!$this->voteEvents->contains($voteEvent)) {
            $this->voteEvents->add($voteEvent);
            $voteEvent->addFilterByArea($this);
        }

        return $this;
    }

    public function removeVoteEvent(VoteEvent $voteEvent): static
    {
        if ($this->voteEvents->removeElement($voteEvent)) {
            $voteEvent->removeFilterByArea($this);
        }

        return $this;
    }
}
