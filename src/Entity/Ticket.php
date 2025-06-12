<?php

namespace App\Entity;

use App\Repository\TicketRepository;

use Carbon\Carbon;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use PhpParser\Node\Expr\Cast\String_;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Delete()
    ],
    normalizationContext: [
        'groups' => ['ticket:read','ticket:write'], 'enable_max_depth'=>true
    ]
)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['ticket:read','ticket:write'])]
    private ?int $id = null;

    
    #[ORM\Column(length: 255)]
    #[Groups(['ticket:read','ticket:write'])]
    private ?string $summary = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['ticket:read','ticket:write'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['ticket:read','ticket:write'])]
    private ?\DateTimeInterface $creation_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['ticket:read','ticket:write'])]
    private ?\DateTimeInterface $modification_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['ticket:read','ticket:write'])]
    private ?\DateTimeInterface $resolution_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['ticket:read','ticket:write'])]
    private ?\DateTimeInterface $close_date = null;

    #[ORM\Column(length: 15, nullable: true)]
    #[Groups(['ticket:read','ticket:write'])]
    private ?string $external_ticket = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
      #[Groups(['ticket:read','ticket:write'])]
    private ?string $resolution = null;

    #[ORM\OneToMany(mappedBy: 'id_ticket', targetEntity: Notes::class)]
    #[Groups(['ticket:read','ticket:write'])]
    private Collection $notes;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['ticket:read','ticket:write'])]
    private ?User $affected_user = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[Groups(['ticket:read','ticket:write'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $id_category = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[Groups(['ticket:read','ticket:write'])]
    private ?Subcategory $id_subcategory = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['ticket:read','ticket:write'])]
    private ?TicketType $id_ticketType = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[Groups(['ticket:read','ticket:write'])]
    private ?Group $assigned_group = null;

    #[ORM\ManyToOne(inversedBy: 'created_tickets')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['ticket:read','ticket:write'])]
    private ?User $creator_user_id = null;

    #[ORM\ManyToOne(inversedBy: 'assigned_tickets')]
    #[Groups(['ticket:read','ticket:write'])]
    private ?User $assigned_user_id = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[Groups(['ticket:read','ticket:write'])]
    private ?Center $id_center = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['ticket:read','ticket:write'])]
    private ?Priority $id_priority = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['ticket:read','ticket:write'])]
    private ?Level $id_level = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[Groups(['ticket:read','ticket:write'])]
    private ?Provider $id_provider = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['ticket:read','ticket:write'])]
    private ?string $affected_user_phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['ticket:read','ticket:write'])]
    private ?string $affected_user_email = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['ticket:read','ticket:write'])]
    private ?State $id_state = null;


    public function __construct(){
        $this->creation_date= new \DateTimeImmutable();
        $this->modification_date = null;
        $this->resolution_date = null;
        $this->close_date = null;
        $this->notes = new ArrayCollection();
    }

    //TODO: Añadir ficheros adjuntos

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    #[Groups(['ticket:read'])]
    public function getCreationDateAgo(): string
    {
        return Carbon::instance($this->creation_date)->diffForHumans();
    }

    public function setCreationDate(\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    } 

    #[Groups(['ticket:read'])]
    public function getModificationDate(): ?\DateTimeInterface
    {
        return $this->modification_date;
    }

    public function setModificationDate(?\DateTimeInterface $modification_date): self
    {
        $this->modification_date = $modification_date;

        return $this;
    }

    #[Groups(['ticket:read'])]
    public function getResolutionDate(): ?\DateTimeInterface
    {
        return $this->resolution_date;
    }

    public function setResolutionDate(?\DateTimeInterface $resolution_date): self
    {
        $this->resolution_date = $resolution_date;

        return $this;
    }

    public function getCloseDate(): ?\DateTimeInterface
    {
        return $this->close_date;
    }

    public function setCloseDate(?\DateTimeInterface $close_date): self
    {
        $this->close_date = $close_date;

        return $this;
    }

    public function getExternalTicket(): ?string
    {
        return $this->external_ticket;
    }

    public function setExternalTicket(?string $external_ticket): self
    {
        $this->external_ticket = $external_ticket;

        return $this;
    }

    public function getResolution(): ?string
    {
        return $this->resolution;
    }

    public function setResolution(?string $resolution): self
    {
        $this->resolution = $resolution;

        return $this;
    }

    /**
     * @return Collection<int, Notes>
     */
    #[ApiResource()]
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Notes $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setIdTicket($this);
        }

        return $this;
    }

    public function removeNote(Notes $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getIdTicket() === $this) {
                $note->setIdTicket(null);
            }
        }

        return $this;
    }

    public function getAffectedUser(): ?User
    {
        return $this->affected_user;
    }

    public function setAffectedUser(?User $affected_user): self
    {
        $this->affected_user = $affected_user;

        return $this;
    }

    public function getIdCategory(): ?Category
    {
        return $this->id_category;
    }

    public function setIdCategory(?Category $id_category): self
    {
        $this->id_category = $id_category;

        return $this;
    }

    public function getIdSubcategory(): ?Subcategory
    {
        return $this->id_subcategory;
    }

    public function setIdSubcategory(?Subcategory $id_subcategory): self
    {
        $this->id_subcategory = $id_subcategory;

        return $this;
    }

    public function getIdTicketType(): ?TicketType
    {
        return $this->id_ticketType;
    }

    public function setIdTicketType(?TicketType $id_ticketType): self
    {
        $this->id_ticketType = $id_ticketType;

        return $this;
    }

    public function getAssignedGroup(): ?Group
    {
        return $this->assigned_group;
    }

    public function setAssignedGroup(?Group $assigned_group): self
    {
        $this->assigned_group = $assigned_group;

        return $this;
    }

    public function getCreatorUserId(): ?User
    {
        return $this->creator_user_id;
    }

    public function setCreatorUserId(?User $creator_user_id): self
    {
        $this->creator_user_id = $creator_user_id;

        return $this;
    }

    public function getAssignedUserId(): ?User
    {
        return $this->assigned_user_id;
    }

    public function setAssignedUserId(?User $assigned_user_id): self
    {
        $this->assigned_user_id = $assigned_user_id;

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

    public function getIdPriority(): ?Priority
    {
        return $this->id_priority;
    }

    public function setIdPriority(?Priority $id_priority): self
    {
        $this->id_priority = $id_priority;

        return $this;
    }

    public function getIdLevel(): ?Level
    {
        return $this->id_level;
    }

    public function setIdLevel(?Level $id_level): self
    {
        $this->id_level = $id_level;

        return $this;
    }

    public function getIdProvider(): ?Provider
    {
        return $this->id_provider;
    }

    public function setIdProvider(?Provider $id_provider): self
    {
        $this->id_provider = $id_provider;

        return $this;
    }

    public function getAffectedUserPhone(): ?string
    {
        return $this->affected_user_phone;
    }

    public function setAffectedUserPhone(?string $affected_user_phone): self
    {
        $this->affected_user_phone = $affected_user_phone;

        return $this;
    }

    public function getAffectedUserEmail(): ?string
    {
        return $this->affected_user_email;
    }

    public function setAffectedUserEmail(?string $affected_user_email): self
    {
        $this->affected_user_email = $affected_user_email;

        return $this;
    }

    public function getIdState(): ?State
    {
        return $this->id_state;
    }

    public function setIdState(?State $id_state): self
    {
        $this->id_state = $id_state;

        return $this;
    }
}
