<?php

namespace App\Entity;

use App\Repository\VoteEventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoteEventRepository::class)]
class VoteEvent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'voteEvents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $added_by = null;

    #[ORM\Column]
    private ?int $votes_per_curator = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $start_time = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $end_time = null;

    #[ORM\Column]
    private ?bool $is_active = null;

    /**
     * @var Collection<int, Vote>
     */
    #[ORM\OneToMany(targetEntity: Vote::class, mappedBy: 'event_id', orphanRemoval: true)]
    private Collection $votes;

    public function __construct()
    {
        $this->votes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddedBy(): ?User
    {
        return $this->added_by;
    }

    public function setAddedBy(?User $added_by): static
    {
        $this->added_by = $added_by;

        return $this;
    }

    public function getVotesPerCurator(): ?int
    {
        return $this->votes_per_curator;
    }

    public function setVotesPerCurator(int $votes_per_curator): static
    {
        $this->votes_per_curator = $votes_per_curator;

        return $this;
    }

    public function getStartTime(): ?\DateTime
    {
        return $this->start_time;
    }

    public function setStartTime(?\DateTime $start_time): static
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getEndTime(): ?\DateTime
    {
        return $this->end_time;
    }

    public function setEndTime(?\DateTime $end_time): static
    {
        $this->end_time = $end_time;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): static
    {
        $this->is_active = $is_active;

        return $this;
    }

    /**
     * @return Collection<int, Vote>
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): static
    {
        if (!$this->votes->contains($vote)) {
            $this->votes->add($vote);
            $vote->setEventId($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): static
    {
        if ($this->votes->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getEventId() === $this) {
                $vote->setEventId(null);
            }
        }

        return $this;
    }
}
