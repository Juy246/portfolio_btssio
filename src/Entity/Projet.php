<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
#[ORM\Table(name: 'projet')]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $matiere = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $link_github = null;

    #[ORM\Column(length: 255)]
    private ?string $link_download = null;

    #[ORM\Column(length: 255)]
    private ?string $categorie = null;

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

    public function getMatiere(): ?string
    {
        return $this->matiere;
    }

    public function setMatiere(string $matiere): static
    {
        $this->matiere = $matiere;

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

    public function getLinkGithub(): ?string
    {
        return $this->link_github;
    }

    public function setLinkGithub(string $link_github): static
    {
        $this->link_github = $link_github;

        return $this;
    }

    public function getLinkDownload(): ?string
    {
        return $this->link_download;
    }

    public function setLinkDownload(string $link_download): static
    {
        $this->link_download = $link_download;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
}
