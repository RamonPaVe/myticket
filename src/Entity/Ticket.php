<?php

namespace App\Entity;

use App\Repository\TicketRepository;

use Carbon\Carbon;
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
    ]
)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    
    #[ORM\Column(length: 255)]
    #[Groups(['read'])]
    private ?string $summary = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['read'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['read'])]
    private ?\DateTimeInterface $creation_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $modification_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $resolution_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $close_date = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $external_ticket = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $resolution = null;


    public function __construct(){
        $this->creation_date= new \DateTimeImmutable();
        $this->modification_date = null;
        $this->resolution_date = null;
        $this->close_date = null;
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

    #[Groups(['read'])]
    public function getCreationDateAgo(): string
    {
        return Carbon::instance($this->creation_date)->diffForHumans();
    }

/*     public function setCreationDate(\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    } */

    public function getModificationDate(): ?\DateTimeInterface
    {
        return $this->modification_date;
    }

    

/*     public function setModificationDate(?\DateTimeInterface $modification_date): self
    {
        $this->modification_date = $modification_date;

        return $this;
    } */

    public function getResolutionDate(): ?\DateTimeInterface
    {
        return $this->resolution_date;
    }

/*     public function setResolutionDate(?\DateTimeInterface $resolution_date): self
    {
        $this->resolution_date = $resolution_date;

        return $this;
    } */

    public function getCloseDate(): ?\DateTimeInterface
    {
        return $this->close_date;
    }

/*     public function setCloseDate(?\DateTimeInterface $close_date): self
    {
        $this->close_date = $close_date;

        return $this;
    } */

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
}
