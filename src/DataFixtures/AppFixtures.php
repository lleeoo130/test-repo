<?php

namespace App\DataFixtures;

use App\Entity\Hero;
use App\Entity\Maze;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $userWithNoHero = (new User())
            ->setUsername('m1n0t4uR')
            ->setEmail('m1n0t4uR@gmail.com')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
            ->setGoogle('666')
        ;

        $hero = (new Hero())
            ->setName('hero_name')
            ->setLevel(1)
        ;

        $userWithHero = (new User())
            ->setUsername('i_have_hero')
            ->setEmail('i_have_hero@gmail.com')
            ->setRoles(['ROLE_USER'])
            ->setGoogle('777')
            ->addHero($hero)
        ;

        $maze = (new Maze())
            ->setWidth(3)
            ->setHeight(3)
            ->setSize(9)
        ;

        $manager->persist($userWithNoHero);
        $manager->persist($hero);
        $manager->persist($userWithHero);
        $manager->persist($maze);

        $manager->flush();
    }
}
