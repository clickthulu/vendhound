<?php

namespace App\Entity;

use App\Repository\MailingAddressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MailingAddressRepository::class)]
class MailingAddress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $street1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $street2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $street3 = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $province = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $postalCode = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\OneToOne(mappedBy: 'MailAddress', cascade: ['persist', 'remove'])]
    private ?Dealership $dealership = null;

    #[ORM\ManyToOne(inversedBy: 'mailingAddresses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $nickname = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet1(): ?string
    {
        return $this->street1;
    }

    public function setStreet1(string $street1): static
    {
        $this->street1 = $street1;

        return $this;
    }

    public function getStreet2(): ?string
    {
        return $this->street2;
    }

    public function setStreet2(?string $street2): static
    {
        $this->street2 = $street2;

        return $this;
    }

    public function getStreet3(): ?string
    {
        return $this->street3;
    }

    public function setStreet3(?string $street3): static
    {
        $this->street3 = $street3;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(?string $province): static
    {
        $this->province = $province;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getDealership(): ?Dealership
    {
        return $this->dealership;
    }

    public function setDealership(?Dealership $dealership): static
    {
        // unset the owning side of the relation if necessary
        if ($dealership === null && $this->dealership !== null) {
            $this->dealership->setMailAddress(null);
        }

        // set the owning side of the relation if necessary
        if ($dealership !== null && $dealership->getMailAddress() !== $this) {
            $dealership->setMailAddress($this);
        }

        $this->dealership = $dealership;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): static
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function load(array $data): static
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        return $this;
    }

}
