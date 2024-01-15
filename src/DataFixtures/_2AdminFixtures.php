<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Symfony\Config\SecurityConfig;
class _2AdminFixtures extends Fixture

{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $role = $this->getReference('role-admin');
        
        $user = new User();
        $user->setFullName('Admin');
        $user->setLevelOfStudy('Adamentite');
        $user->setEmail('admin@admin.com');
        $password = $this->hasher->hashPassword($user, 'password');
        $user->setPassword($password);
        
        $user->setRole($role);

        $manager->persist($user);

        $manager->flush();
    }
}
