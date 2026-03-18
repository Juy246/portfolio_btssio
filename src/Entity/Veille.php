<?php

namespace App\Entity;

use App\Repository\VeilleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VeilleRepository::class)]
class Veille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    private ?string $titre = null;
    #[ORM\Column(type:Types::TEXT)]
    private ?string $description = null;
    #[ORM\Column(length: 500)]
    private ?string $url = null;
    #[ORM\Column(type:Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;
    #[ORM\Column(type:Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getTitre(): ?string
    {
        return $this->titre;
    }
    public function setTitre(string $titre): static
    {
        $this->titre = $titre;
        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }
    public function getUrl(): ?string
    {
        return $this->url;
    }
    public function setUrl(string $url): static
    {
        $this->url = $url;
        return $this;
    }
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }
    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }
    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTime();
        }
        if ($this->date === null) {
            $this->date = new \DateTime();
        }
    }
}
