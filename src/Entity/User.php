<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\UserController;
use App\Repository\UserRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bridge\Doctrine\ArgumentResolver\EntityValueResolver;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[ApiResource]
#[Get()]

#[Post(
    denormalizationContext: ['groups' => ['write']]
)]

#[Put()]
#[Patch(
    name: 'user_apply',
    uriTemplate: 'user_appy/formamtion/{id}',
    controller: UserController::class,
    denormalizationContext: [ 'groups' => ['write_appy_for_one_formation'] ],
    normalizationContext: [ 'groups' => ['read_appy_for_one_formation'] ],

)]
#[Delete()]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups('write', 'write_apply_for_one_formation' )]
    // #[Groups('write_apply_for_one_formation')]
    private ?string $full_name = null;

    #[ORM\Column(length: 50)]
    #[Groups('write', 'write_apply_for_one_formation' )]
    private ?string $level_of_study = null;

    #[ORM\Column(length: 255)]
    #[Groups('write', 'write_apply_for_one_formation' )]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups('write', 'write_apply_for_one_formation' )]
    private ?string $password = null;

    #[ORM\ManyToOne(inversedBy: 'roles')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Role $role = null;

    #[ORM\ManyToOne(inversedBy: 'formations')]
    // #[Groups('read_apply_for_one_formation')]
    private ?Formation $formation = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    public function isAdmin(): bool
    {
        return \in_array('ROLE_ADMIN', $this->getRoles());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): static
    {
        $this->full_name = $full_name;

        return $this;
    }

    public function getLevelOfStudy(): ?string
    {
        return $this->level_of_study;
    }

    public function setLevelOfStudy(string $level_of_study): static
    {
        $this->level_of_study = $level_of_study;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getRoles(): array
    {
        $role = $this->getRole();

        if ($role) 
        {
            return [$role->getRole()];
        }
        // If $role is null, return an array with the default role, e.g., 'ROLE_USER'
        return ['ROLE_USER'];
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }


    public function setFormation(?Formation $formation): static
    {
        $this->formation = $formation;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
