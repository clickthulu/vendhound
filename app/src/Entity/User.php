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
    private DateTime $createdOn;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'UploadedBy', orphanRemoval: true)]
    private Collection $images;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Dealership $dealership = null;

    #[ORM\Column]
    private bool $isRegistered = false;

    #[ORM\Column]
    private bool $isPaid = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phoneNumber = null;

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

    /**
     * @var Collection<int, MailingAddress>
     */
    #[ORM\OneToMany(targetEntity: MailingAddress::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $mailingAddresses;

    #[ORM\OneToOne(mappedBy: 'owner', cascade: ['persist', 'remove'])]
    private ?Dealership $mainDealership = null;

    public function __construct()
    {
        $this->createdOn = new DateTime();
        $this->images = new ArrayCollection();
        $this->votes = new ArrayCollection();
        $this->voteEvents = new ArrayCollection();
        $this->mailingAddresses = new ArrayCollection();
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
     * @param string $role
     * @return $this
     */
    public function addRole(string $role): static
    {
        $this->roles[] = $role;
        $this->roles = array_unique($this->roles);
        return $this;
    }

    /**
     * @param string $role
     * @return $this
     */
    public function removeRole(string $role): static
    {
        $roles = [];
        foreach ($this->roles as $userrole) {
            if (strtoupper($role) === strtoupper($userrole)) {
                continue;
            }
            $roles[] = $userrole;
        }
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
        return $this->createdOn;
    }

    public function setCreatedOn(DateTime $createdOn): static
    {
        $this->createdOn = $createdOn;

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

    public function getDealership(): ?Dealership
    {
        return $this->dealership;
    }

    public function setDealership(?Dealership $dealership): static
    {
        $this->dealership = $dealership;

        return $this;
    }

    public function isRegistered(): ?bool
    {
        return $this->isRegistered;
    }

    public function setIsRegistered(bool $isRegistered): static
    {
        $this->isRegistered = $isRegistered;

        return $this;
    }

    public function isPaid(): ?bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(bool $isPaid): static
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

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

    /**
     * @return Collection<int, MailingAddress>
     */
    public function getMailingAddresses(): Collection
    {
        return $this->mailingAddresses;
    }

    public function addMailingAddress(MailingAddress $mailingAddress): static
    {
        if (!$this->mailingAddresses->contains($mailingAddress)) {
            $this->mailingAddresses->add($mailingAddress);
            $mailingAddress->setUser($this);
        }

        return $this;
    }

    public function removeMailingAddress(MailingAddress $mailingAddress): static
    {
        if ($this->mailingAddresses->removeElement($mailingAddress)) {
            // set the owning side to null (unless already changed)
            if ($mailingAddress->getUser() === $this) {
                $mailingAddress->setUser(null);
            }
        }

        return $this;
    }

    public function getMainDealership(): ?Dealership
    {
        return $this->mainDealership;
    }

    public function setMainDealership(Dealership $mainDealership): static
    {
        // set the owning side of the relation if necessary
        if ($mainDealership->getOwner() !== $this) {
            $mainDealership->setOwner($this);
        }

        $this->mainDealership = $mainDealership;

        return $this;
    }
}
