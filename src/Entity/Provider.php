<?php

namespace App\Entity;

use App\Repository\ProviderRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: ProviderRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Delete(),
    ],
    normalizationContext: [
        'groups' => ['ticket:read', 'provider:read']
    ]
)]
class Provider
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['ticket:read', 'provider:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['ticket:read', 'provider:read'])]
    private ?string $provider_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['provider:read'])]
    private ?string $provider_email = null;

    #[ORM\Column(length: 25, nullable: true)]
    #[Groups(['provider:read'])]
    private ?string $provider_phone = null;

    #[ORM\OneToMany(mappedBy: 'id_provider', targetEntity: Ticket::class)]
    private Collection $tickets;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setIdProvider($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getIdProvider() === $this) {
                $ticket->setIdProvider(null);
            }
        }

        return $this;
    }
}
