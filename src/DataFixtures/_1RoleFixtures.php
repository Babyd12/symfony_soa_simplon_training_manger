<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class _1RoleFixtures extends Fixture implements FixtureGroupInterface
{

    public static function getGroups(): array
    {
        return ['roles'];
    }
    
    public function load(ObjectManager $manager): void
    {
        $role = new Role();
        $role->setRole('ROLE_ADMIN');
        $manager->persist($role);
        $manager->flush();

        //ajouter une reference pour lutilisateur utilérieur   
        $this->addReference('role-admin', $role);

        $role = new Role();
        $role->setRole('ROLE_USER');
        $manager->persist($role);
        $manager->flush();

        //ajouter une reference pour lutilisateur utilérieur
        $this->addReference('role-user', $role);
      
    }

    
}
