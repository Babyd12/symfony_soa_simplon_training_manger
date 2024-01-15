<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
#[ApiResource]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $role = null;

    #[ORM\OneToMany(mappedBy: 'role', targetEntity: User::class)]
    private Collection $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(User $role): static
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
            $role->setRole($this);
        }

        return $this;
    }

    public function removeRole(User $role): static
    {
        if ($this->roles->removeElement($role)) {
            // set the owning side to null (unless already changed)
            if ($role->getRole() === $this) {
                $role->setRole(null);
            }
        }

        return $this;
    }
}
