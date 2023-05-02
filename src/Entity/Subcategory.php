<?php

namespace App\Entity;

use App\Repository\SubcategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

#[ApiResource]
#[ORM\Entity(repositoryClass: SubcategoryRepository::class)]
class Subcategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $subcategory_name = null;

    #[ORM\ManyToOne(inversedBy: 'Subcategory')]
    private ?Category $category = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubcategoryName(): ?string
    {
        return $this->subcategory_name;
    }

    public function setSubcategoryName(string $subcategory_name): self
    {
        $this->subcategory_name = $subcategory_name;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
