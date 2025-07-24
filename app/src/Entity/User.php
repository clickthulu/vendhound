<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private bool $isVerified = false;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private ?DateTime $created_on = null;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'UploadedBy', orphanRemoval: true)]
    private Collection $images;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Dealership $assoc_dealership = null;

    #[ORM\Column]
    private ?bool $is_registered = null;

    #[ORM\Column]
    private ?bool $is_paid = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone_number = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mailing_address = null;

    /**
     * @var Collection<int, Vote>
     */
    #[ORM\OneToMany(targetEntity: Vote::class, mappedBy: 'voter_id', orphanRemoval: true)]
    private Collection $votes;

    /**
     * @var Collection<int, VoteEvent>
     */
    #[ORM\OneToMany(targetEntity: VoteEvent::class, mappedBy: 'added_by')]
    private Collection $voteEvents;

    public function __construct()
    {
        $this->created_on = new DateTime();
        $this->images = new ArrayCollection();
        $this->votes = new ArrayCollection();
        $this->voteEvents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getCreatedOn(): DateTime
    {
        return $this->created_on;
    }

    public function setCreatedOn(DateTime $created_on): static
    {
        $this->created_on = $created_on;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setUploadedBy($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getUploadedBy() === $this) {
                $image->setUploadedBy(null);
            }
        }

        return $this;
    }

    public function getAssocDealership(): ?Dealership
    {
        return $this->assoc_dealership;
    }

    public function setAssocDealership(?Dealership $assoc_dealership): static
    {
        $this->assoc_dealership = $assoc_dealership;

        return $this;
    }

    public function isRegistered(): ?bool
    {
        return $this->is_registered;
    }

    public function setIsRegistered(bool $is_registered): static
    {
        $this->is_registered = $is_registered;

        return $this;
    }

    public function isPaid(): ?bool
    {
        return $this->is_paid;
    }

    public function setIsPaid(bool $is_paid): static
    {
        $this->is_paid = $is_paid;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): static
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getMailingAddress(): ?string
    {
        return $this->mailing_address;
    }

    public function setMailingAddress(?string $mailing_address): static
    {
        $this->mailing_address = $mailing_address;

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
            $vote->setVoterId($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): static
    {
        if ($this->votes->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getVoterId() === $this) {
                $vote->setVoterId(null);
            }
        }

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
            $voteEvent->setAddedBy($this);
        }

        return $this;
    }

    public function removeVoteEvent(VoteEvent $voteEvent): static
    {
        if ($this->voteEvents->removeElement($voteEvent)) {
            // set the owning side to null (unless already changed)
            if ($voteEvent->getAddedBy() === $this) {
                $voteEvent->setAddedBy(null);
            }
        }

        return $this;
    }
}
