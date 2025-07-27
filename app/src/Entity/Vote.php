<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoteRepository::class)]
class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'votes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $voter_id = null;

    #[ORM\ManyToOne(inversedBy: 'votes')]
    private ?Dealership $voted_for = null;

    #[ORM\ManyToOne(inversedBy: 'votes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?VoteEvent $event_id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $last_updated = null;

    #[ORM\Column]
    private ?\DateTime $created_on = null;

    #[ORM\Column]
    private ?int $update_count = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVoterId(): ?User
    {
        return $this->voter_id;
    }

    public function setVoterId(?User $voter_id): static
    {
        $this->voter_id = $voter_id;

        return $this;
    }

    public function getVotedFor(): ?Dealership
    {
        return $this->voted_for;
    }

    public function setVotedFor(?Dealership $voted_for): static
    {
        $this->voted_for = $voted_for;

        return $this;
    }

    public function getEventId(): ?VoteEvent
    {
        return $this->event_id;
    }

    public function setEventId(?VoteEvent $event_id): static
    {
        $this->event_id = $event_id;

        return $this;
    }

    public function getLastUpdated(): ?\DateTime
    {
        return $this->last_updated;
    }

    public function setLastUpdated(?\DateTime $last_updated): static
    {
        $this->last_updated = $last_updated;

        return $this;
    }

    public function getCreatedOn(): ?\DateTime
    {
        return $this->created_on;
    }

    public function setCreatedOn(\DateTime $created_on): static
    {
        $this->created_on = $created_on;

        return $this;
    }

    public function getUpdateCount(): ?int
    {
        return $this->update_count;
    }

    public function setUpdateCount(int $update_count): static
    {
        $this->update_count = $update_count;

        return $this;
    }
}
