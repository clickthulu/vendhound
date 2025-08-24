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

    #[ORM\Column(length: 255)]
    private ?string $email = null;


    #[ORM\Column(length: 255)]
    private ?string $legalname = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $taxID = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $productsAndServices = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rating = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $specialRequests = null;

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
    private DateTime $createdOn;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'AssocDealership')]
    private Collection $images;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'assoc_dealership')]
    private Collection $users;

    #[ORM\Column]
    private ?bool $isAccepted = null;

    #[ORM\Column]
    private ?bool $isPaid = null;

    /**
     * @var Collection<int, Vote>
     */
    #[ORM\OneToMany(targetEntity: Vote::class, mappedBy: 'voted_for')]
    private Collection $votes;

    #[ORM\OneToOne(inversedBy: 'dealership')]
    private ?MailingAddress $MailAddress = null;

    /**
     * @var Collection<int, Table>
     */
    #[ORM\OneToMany(targetEntity: Table::class, mappedBy: 'dealership')]
    private Collection $assignedTables;

    #[ORM\ManyToOne]
    private ?DealerArea $area = null;

    #[ORM\OneToOne(inversedBy: 'mainDealership', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $businessEmail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $businessPhone = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'dealershipsSecond')]
    private ?TableType $tableRequestTypeSecond = null;

    #[ORM\ManyToOne(inversedBy: 'dealershipsThree')]
    private ?TableType $tableRequestTypeThree = null;

    #[ORM\ManyToOne(inversedBy: 'dealerships')]
    private ?TableAddOn $TableAddOn = null;


    public function __construct()
    {
        $this->createdOn = new DateTime();
        $this->categories = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->votes = new ArrayCollection();
        $this->assignedTables = new ArrayCollection();
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
        return $this->createdOn;
    }

    /**
     * @param DateTime $createdOn
     * @return Dealership
     */
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
            $image->setAssocDealership($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getAssocDealership() === $this) {
                $image->setAssocDealership(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setDealership($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getDealership() === $this) {
                $user->setDealership(null);
            }
        }

        return $this;
    }

    public function isAccepted(): ?bool
    {
        return $this->isAccepted;
    }

    public function setIsAccepted(bool $isAccepted): static
    {
        $this->isAccepted = $isAccepted;

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
            $vote->setVotedFor($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): static
    {
        if ($this->votes->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getVotedFor() === $this) {
                $vote->setVotedFor(null);
            }
        }

        return $this;
    }

    public function getMailAddress(): ?MailingAddress
    {
        return $this->MailAddress;
    }

    public function setMailAddress(?MailingAddress $MailAddress): static
    {
        $this->MailAddress = $MailAddress;

        return $this;
    }

    /**
     * @return Collection<int, Table>
     */
    public function getAssignedTables(): Collection
    {
        return $this->assignedTables;
    }

    public function addAssignedTable(Table $assignedTable): static
    {
        if (!$this->assignedTables->contains($assignedTable)) {
            $this->assignedTables->add($assignedTable);
            $assignedTable->setDealership($this);
        }

        return $this;
    }

    public function removeAssignedTable(Table $assignedTable): static
    {
        if ($this->assignedTables->removeElement($assignedTable)) {
            // set the owning side to null (unless already changed)
            if ($assignedTable->getDealership() === $this) {
                $assignedTable->setDealership(null);
            }
        }

        return $this;
    }

    public function getArea(): ?DealerArea
    {
        return $this->area;
    }

    public function setArea(?DealerArea $area): static
    {
        $this->area = $area;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getBusinessEmail(): ?string
    {
        return $this->businessEmail;
    }

    public function setBusinessEmail(?string $businessEmail): static
    {
        $this->businessEmail = $businessEmail;

        return $this;
    }

    public function getBusinessPhone(): ?string
    {
        return $this->businessPhone;
    }

    public function setBusinessPhone(?string $businessPhone): static
    {
        $this->businessPhone = $businessPhone;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getLegalname(): ?string
    {
        return $this->legalname;
    }

    /**
     * @param string|null $legalname
     */
    public function setLegalname(?string $legalname): void
    {
        $this->legalname = $legalname;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string|null
     */
    public function getWebsite(): ?string
    {
        return $this->website;
    }

    /**
     * @param string|null $website
     */
    public function setWebsite(?string $website): void
    {
        $this->website = $website;
    }

    /**
     * @return string|null
     */
    public function getRating(): ?string
    {
        return $this->rating;
    }

    /**
     * @param string|null $rating
     */
    public function setRating(?string $rating): void
    {
        $this->rating = $rating;
    }

    /**
     * @return string|null
     */
    public function getSpecialRequests(): ?string
    {
        return $this->specialRequests;
    }

    /**
     * @param string|null $specialRequests
     */
    public function setSpecialRequests(?string $specialRequests): void
    {
        $this->specialRequests = $specialRequests;
    }

    public function getTableRequestTypeSecond(): ?TableType
    {
        return $this->tableRequestTypeSecond;
    }

    public function setTableRequestTypeSecond(?TableType $tableRequestTypeSecond): static
    {
        $this->tableRequestTypeSecond = $tableRequestTypeSecond;

        return $this;
    }

    public function getTableRequestTypeThree(): ?TableType
    {
        return $this->tableRequestTypeThree;
    }

    public function setTableRequestTypeThree(?TableType $tableRequestTypeThree): static
    {
        $this->tableRequestTypeThree = $tableRequestTypeThree;

        return $this;
    }

    public function getTableAddOn(): ?TableAddOn
    {
        return $this->TableAddOn;
    }

    public function setTableAddOn(?TableAddOn $TableAddOn): static
    {
        $this->TableAddOn = $TableAddOn;

        return $this;
    }


}
