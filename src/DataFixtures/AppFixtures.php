<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = (new User())
            ->setUsername('m1n0t4uR')
            ->setEmail('m1n0t4uR@gmail.com')
            ->setRoles(['ROLE_USER'])
            ->setGoogle('666')
        ;

        $manager->persist($user);

        $manager->flush();
    }
}
