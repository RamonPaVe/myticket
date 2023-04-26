<?php

namespace App\Entity;

use App\Repository\ProviderRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;


#[ApiResource]
#[ORM\Entity(repositoryClass: ProviderRepository::class)]
class Provider
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $provider_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $provider_email = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $provider_phone = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProviderName(): ?string
    {
        return $this->provider_name;
    }

    public function setProviderName(string $provider_name): self
    {
        $this->provider_name = $provider_name;

        return $this;
    }

    public function getProviderEmail(): ?string
    {
        return $this->provider_email;
    }

    public function setProviderEmail(?string $provider_email): self
    {
        $this->provider_email = $provider_email;

        return $this;
    }

    public function getProviderPhone(): ?string
    {
        return $this->provider_phone;
    }

    public function setProviderPhone(?string $provider_phone): self
    {
        $this->provider_phone = $provider_phone;

        return $this;
    }
}
