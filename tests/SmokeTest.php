<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Component\Panther\PantherTestCase;
use Symfony\Component\Security\Core\User\UserInterface;

class SmokeTest extends PantherTestCase
{
    public function testNotConnected(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login/');

        $this->assertAnySelectorTextContains('a', 'google');
    }

    public function testConnected(): void
    {
        static::bootKernel();
        $client = static::createClient();

        $user = $this->getUser('m1n0t4uR@gmail.com');

        $client->loginUser($user);

        $crawler = $client->request('GET', '/login/');

        $this->assertAnySelectorTextContains('a', 'google');
    }

    private function getUser(string $email): UserInterface
    {
        $entityManager = self::$kernel->getContainer()->get('doctrine')->getManager();

        return $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
    }
}
