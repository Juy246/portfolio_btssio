<?php

namespace App\Entity;

use App\Repository\ExperienceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExperienceRepository::class)]
#[ORM\Table(name: '`experience`')]
class Experience
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 100)]
    private ?string $type = null; // 'education' ou 'professional'

    #[ORM\Column(length: 255)]
    private ?string $company = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(length: 20)]
    private ?string $startDate = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $endDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $displayOrder = null;

    #[ORM\ManyToMany(targetEntity: Competence::class)]
    #[ORM\JoinTable(name: 'experience_competence')]
    private Collection $skills;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getTitle(): ?string { return $this->title; }
    public function setTitle(string $title): static { $this->title = $title; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): static { $this->description = $description; return $this; }

    public function getType(): ?string { return $this->type; }
    public function setType(string $type): static { $this->type = $type; return $this; }

    public function getCompany(): ?string { return $this->company; }
    public function setCompany(string $company): static { $this->company = $company; return $this; }

    public function getLocation(): ?string { return $this->location; }
    public function setLocation(?string $location): static { $this->location = $location; return $this; }

    public function getStartDate(): ?string { return $this->startDate; }
    public function setStartDate(string $startDate): static { $this->startDate = $startDate; return $this; }

    public function getEndDate(): ?string { return $this->endDate; }
    public function setEndDate(?string $endDate): static { $this->endDate = $endDate; return $this; }

    public function getDisplayOrder(): ?int { return $this->displayOrder; }
    public function setDisplayOrder(?int $displayOrder): static { $this->displayOrder = $displayOrder; return $this; }

    public function getSkills(): Collection { return $this->skills; }

    public function addSkill(Competence $skill): static
    {
        if (!$this->skills->contains($skill)) { $this->skills->add($skill); }
        return $this;
    }

    public function removeSkill(Competence $skill): static
    {
        $this->skills->removeElement($skill);
        return $this;
    }

    public function getPeriod(): string
    {
        $start = \DateTime::createFromFormat('Y-m', $this->startDate)?->format('m/Y') ?? $this->startDate;
        if ($this->endDate) {
            $end = \DateTime::createFromFormat('Y-m', $this->endDate)?->format('m/Y') ?? $this->endDate;
            return "{$start} - {$end}";
        }
        return "{$start} - Present";
    }
}
