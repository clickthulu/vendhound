<?php

namespace App\Entity;

use App\Repository\VoteEventRepository;
use DateTime;
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
    private ?User $addedBy = null;

    #[ORM\Column]
    private ?int $votesPerCurator = null;

    #[ORM\Column(nullable: true)]
    private ?DateTime $startTime = null;

    #[ORM\Column(nullable: true)]
    private ?DateTime $endTime = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column]
    private DateTime $createdOn;

    /**
     * @var Collection<int, Vote>
     */
    #[ORM\OneToMany(targetEntity: Vote::class, mappedBy: 'event_id', orphanRemoval: true)]
    private Collection $votes;

    #[ORM\Column(nullable: true)]
    private ?int $maxCuratorVotesPerApplicant = null;

    /**
     * @var Collection<int, DealerArea>
     */
    #[ORM\ManyToMany(targetEntity: DealerArea::class, inversedBy: 'voteEvents')]
    private Collection $filterByArea;

    /**
     * @var Collection<int, TableType>
     */
    #[ORM\ManyToMany(targetEntity: TableType::class, inversedBy: 'voteEvents')]
    private Collection $filterByTableType;

    /**
     * @var Collection<int, Tag>
     */
    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'voteEvents')]
    private Collection $filterByTag;

    #[ORM\Column(length: 10000, nullable: true)]
    private ?string $sqlQuery = null;

    public function __construct()
    {
        $this->createdOn = new DateTime();
        $this->votes = new ArrayCollection();
        $this->filterByArea = new ArrayCollection();
        $this->filterByTableType = new ArrayCollection();
        $this->filterByTag = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddedBy(): ?User
    {
        return $this->addedBy;
    }

    public function setAddedBy(?User $addedBy): static
    {
        $this->addedBy = $addedBy;

        return $this;
    }

    public function getVotesPerCurator(): ?int
    {
        return $this->votesPerCurator;
    }

    public function setVotesPerCurator(int $votesPerCurator): static
    {
        $this->votesPerCurator = $votesPerCurator;

        return $this;
    }

    public function getStartTime(): ?DateTime
    {
        return $this->startTime;
    }

    public function setStartTime(?DateTime $startTime): static
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?DateTime
    {
        return $this->endTime;
    }

    public function setEndTime(?DateTime $endTime): static
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

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

    /**
     * @return DateTime
     */
    public function getCreatedOn(): DateTime
    {
        return $this->createdOn;
    }

    /**
     * @param DateTime $createdOn
     */
    public function setCreatedOn(DateTime $createdOn): void
    {
        $this->createdOn = $createdOn;
    }

    public function getMaxCuratorVotesPerApplicant(): ?int
    {
        return $this->maxCuratorVotesPerApplicant;
    }

    public function setMaxCuratorVotesPerApplicant(?int $maxCuratorVotesPerApplicant): static
    {
        $this->maxCuratorVotesPerApplicant = $maxCuratorVotesPerApplicant;

        return $this;
    }

    /**
     * @return Collection<int, DealerArea>
     */
    public function getFilterByArea(): Collection
    {
        return $this->filterByArea;
    }

    public function addFilterByArea(DealerArea $filterByArea): static
    {
        if (!$this->filterByArea->contains($filterByArea)) {
            $this->filterByArea->add($filterByArea);
        }

        return $this;
    }

    public function removeFilterByArea(DealerArea $filterByArea): static
    {
        $this->filterByArea->removeElement($filterByArea);

        return $this;
    }

    /**
     * @return Collection<int, TableType>
     */
    public function getFilterByTableType(): Collection
    {
        return $this->filterByTableType;
    }

    public function addFilterByTableType(TableType $filterByTableType): static
    {
        if (!$this->filterByTableType->contains($filterByTableType)) {
            $this->filterByTableType->add($filterByTableType);
        }

        return $this;
    }

    public function removeFilterByTableType(TableType $filterByTableType): static
    {
        $this->filterByTableType->removeElement($filterByTableType);

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getFilterByTag(): Collection
    {
        return $this->filterByTag;
    }

    public function addFilterByTag(Tag $filterByTag): static
    {
        if (!$this->filterByTag->contains($filterByTag)) {
            $this->filterByTag->add($filterByTag);
        }

        return $this;
    }

    public function removeFilterByTag(Tag $filterByTag): static
    {
        $this->filterByTag->removeElement($filterByTag);

        return $this;
    }

    public function getSqlQuery(): ?string
    {
        return $this->sqlQuery;
    }

    public function setSqlQuery(?string $sqlQuery): static
    {
        $this->sqlQuery = $sqlQuery;

        return $this;
    }


}
