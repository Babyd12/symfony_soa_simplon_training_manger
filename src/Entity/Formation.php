<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use App\Repository\FormationRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
#[ApiResource]

#[Get()]

#[Post(
    denormalizationContext: [ 'groups'=> ['write']  ]
)]

#[Put()]

#[Delete()]


class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups('write')]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups('write')]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups('write')]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column]
    #[Groups('write')]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\OneToMany(mappedBy: 'formation', targetEntity: User::class)]
    private Collection $formations;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeImmutable $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(User $formation): static
    {
        if (!$this->formations->contains($formation)) {
            $this->formations->add($formation);
            $formation->setFormation($this);
        }

        return $this;
    }

    public function removeFormation(User $formation): static
    {
        if ($this->formations->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getFormation() === $this) {
                $formation->setFormation(null);
            }
        }

        return $this;
    }
}
