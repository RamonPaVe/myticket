<?php

namespace App\Entity;

use App\Repository\UserRepository;
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


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Delete(),
    ],
    normalizationContext: [
        'groups' => ['group:read','center:read', 'user:read', 'ticket:read']
    ]
)]
class User 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read','group:read','center:read', 'ticket:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['user:read','group:read','center:read', 'ticket:read'])]
    private ?string $username = null;

    #[ORM\Column(length: 100)]
    #[Groups(['user:read','group:read','center:read', 'ticket:read'])]
    private ?string $surname = null;
    

    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['user:read'])]
    private ?string $user_email = null;

    #[ORM\Column(length: 25)]
    #[Groups(['user:read'])]
    private ?string $password = null;

    #[ORM\Column(length: 25, nullable: true)]
    #[Groups(['user:read'])]
    private ?string $user_phone = null;

    #[ORM\Column(length: 9)]
    #[Groups(['user:read'])]
    private ?string $dni = null;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?bool $active = null;

    #[ORM\ManyToMany(targetEntity: Group::class, inversedBy: 'users')]
    private Collection $groups;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['user:read'])]
    private ?Center $id_center = null;

    #[ORM\OneToMany(mappedBy: 'id_user', targetEntity: Notes::class)]
    private Collection $notes;

    #[ORM\OneToMany(mappedBy: 'affected_user', targetEntity: Ticket::class)]
    private Collection $tickets;

    #[ORM\OneToMany(mappedBy: 'creator_user_id', targetEntity: Ticket::class)]
    private Collection $created_tickets;

    #[ORM\OneToMany(mappedBy: 'assigned_user_id', targetEntity: Ticket::class)]
    private Collection $assigned_tickets;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->tickets = new ArrayCollection();
        $this->created_tickets = new ArrayCollection();
        $this->assigned_tickets = new ArrayCollection();
    }


    // #[ORM\Column(type: 'json')]
    // private array $roles = [];

    
    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->username;
    }

    public function setUserName(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->user_email;
    }

    public function setUserEmail(?string $user_email): self
    {
        $this->user_email = $user_email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUserPhone(): ?string
    {
        return $this->user_phone;
    }

    public function setUserPhone(?string $user_phone): self
    {
        $this->user_phone = $user_phone;

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, Group>
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups->add($group);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        $this->groups->removeElement($group);

        return $this;
    }

    public function getIdCenter(): ?Center
    {
        return $this->id_center;
    }

    public function setIdCenter(?Center $id_center): self
    {
        $this->id_center = $id_center;

        return $this;
    }

    /**
     * @return Collection<int, Notes>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Notes $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
        }

        return $this;
    }

    public function removeNote(Notes $note): self
    {
        if ($this->notes->removeElement($note)) {
            if ($note->getIdUser() === $this) {
                $note->setIdUser(null);
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
            $ticket->setAffectedUser($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getAffectedUser() === $this) {
                $ticket->setAffectedUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getCreatedTickets(): Collection
    {
        return $this->created_tickets;
    }

    public function addCreatedTicket(Ticket $createdTicket): self
    {
        if (!$this->created_tickets->contains($createdTicket)) {
            $this->created_tickets->add($createdTicket);
            $createdTicket->setCreatorUserId($this);
        }

        return $this;
    }

    public function removeCreatedTicket(Ticket $createdTicket): self
    {
        if ($this->created_tickets->removeElement($createdTicket)) {
            // set the owning side to null (unless already changed)
            if ($createdTicket->getCreatorUserId() === $this) {
                $createdTicket->setCreatorUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getAssignedTickets(): Collection
    {
        return $this->assigned_tickets;
    }

    public function addAssignedTicket(Ticket $assignedTicket): self
    {
        if (!$this->assigned_tickets->contains($assignedTicket)) {
            $this->assigned_tickets->add($assignedTicket);
            $assignedTicket->setAssignedUserId($this);
        }

        return $this;
    }

    public function removeAssignedTicket(Ticket $assignedTicket): self
    {
        if ($this->assigned_tickets->removeElement($assignedTicket)) {
            // set the owning side to null (unless already changed)
            if ($assignedTicket->getAssignedUserId() === $this) {
                $assignedTicket->setAssignedUserId(null);
            }
        }

        return $this;
    }



     /**
     * The public representation of the user (e.g. a username, an email address, etc.)
     *
     * @see UserInterface
     */
    // public function getUserIdentifier(): string
    // {
    //     return (string) $this->user_email;
    // }

    /**
     * @see UserInterface
      */
    // public function getRoles(): array
    // {
    //     $roles = $this->roles;
    //     // guarantee every user at least has ROLE_USER
    //     $roles[] = 'ROLE_USER';

    //     return array_unique($roles);
    // }

    // public function setRoles(array $roles): self
    // {
    //     $this->roles = $roles;

    //     return $this;
    // }
    // /**
    //  * @see UserInterface
    //  */
    // public function eraseCredentials(): void
    // {
    //     // If you store any temporary, sensitive data on the user, clear it here
    //     // $this->plainPassword = null;
    // }


    }
