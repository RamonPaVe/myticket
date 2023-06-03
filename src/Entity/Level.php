<?php

namespace App\Entity;

use App\Repository\LevelRepository;
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


#[ORM\Entity(repositoryClass: LevelRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Delete(),
    ],
    normalizationContext: [
        'groups' => ['level:read', 'ticket:read'],
    ]
)]
class Level
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['level:read', 'ticket:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    #[Groups(['level:read', 'ticket:read'])]
    private ?string $level_name = null;

    #[ORM\OneToMany(mappedBy: 'level', targetEntity: Priority::class, cascade:["remove"])]
    #[Groups(['level:read'])]
    private Collection $id_priority;

    #[ORM\OneToMany(mappedBy: 'id_level', targetEntity: Ticket::class)]
    private Collection $tickets;

    public function __construct()
    {
        $this->id_priority = new ArrayCollection();
        $this->tickets = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevelName(): ?string
    {
        return $this->level_name;
    }

    public function setLevelName(string $level_name): self
    {
        $this->level_name = $level_name;

        return $this;
    }

    /**
     * @return Collection<int, Priority>
     */
    public function getIdPriority(): Collection
    {
        return $this->id_priority;
    }

    public function addIdPriority(Priority $idPriority): self
    {
        if (!$this->id_priority->contains($idPriority)) {
            $this->id_priority->add($idPriority);
            $idPriority->setLevel($this);
        }

        return $this;
    }

    public function removeIdPriority(Priority $idPriority): self
    {
        if ($this->id_priority->removeElement($idPriority)) {
            // set the owning side to null (unless already changed)
            if ($idPriority->getLevel() === $this) {
                $idPriority->setLevel(null);
            }
        }

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
            $ticket->setIdLevel($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getIdLevel() === $this) {
                $ticket->setIdLevel(null);
            }
        }

        return $this;
    }
}
