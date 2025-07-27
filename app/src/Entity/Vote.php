<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use DateTime;
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
    private ?User $voterId = null;

    #[ORM\ManyToOne(inversedBy: 'votes')]
    private ?Dealership $votedFor = null;

    #[ORM\ManyToOne(inversedBy: 'votes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?VoteEvent $eventId = null;

    #[ORM\Column(nullable: true)]
    private ?DateTime $lastUpdated = null;

    #[ORM\Column]
    private DateTime $createdOn;

    #[ORM\Column]
    private ?int $updateCount = 0;

    public function __construct()
    {
        $this->createdOn = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVoterId(): ?User
    {
        return $this->voterId;
    }

    public function setVoterId(?User $voterId): static
    {
        $this->voterId = $voterId;

        return $this;
    }

    public function getVotedFor(): ?Dealership
    {
        return $this->votedFor;
    }

    public function setVotedFor(?Dealership $votedFor): static
    {
        $this->votedFor = $votedFor;

        return $this;
    }

    public function getEventId(): ?VoteEvent
    {
        return $this->eventId;
    }

    public function setEventId(?VoteEvent $eventId): static
    {
        $this->eventId = $eventId;

        return $this;
    }

    public function getLastUpdated(): ?DateTime
    {
        return $this->lastUpdated;
    }

    public function setLastUpdated(?DateTime $lastUpdated): static
    {
        $this->lastUpdated = $lastUpdated;

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

    public function getUpdateCount(): ?int
    {
        return $this->updateCount;
    }

    public function setUpdateCount(int $updateCount): static
    {
        $this->updateCount = $updateCount;

        return $this;
    }
}
