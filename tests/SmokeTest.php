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

        $crawler = $client->request('GET', '/');

        $this->assertAnySelectorTextContains('h1', 'Hello m1n0t4uR !');
    }

    public function testIsAdmin(): void
    {
        static::bootKernel();
        $client = static::createClient();

        $user = $this->getUser('m1n0t4uR@gmail.com');

        $client->loginUser($user);

        $crawler = $client->request('GET', '/');

        $this->assertAnySelectorTextContains('h1', 'Hello m1n0t4uR !');
        $this->assertAnySelectorTextContains('a', 'admin dashboard');
    }

    public function testAdminDashboard(): void
    {
        static::bootKernel();
        $client = static::createClient();

        $user = $this->getUser('m1n0t4uR@gmail.com');

        $client->loginUser($user);

        $crawler = $client->request('GET', '/admin');

        $this->assertAnySelectorTextContains('h1', 'Hello Admin m1n0t4uR !');
        $this->assertAnySelectorTextContains('a', 'manage mazes');
    }

    public function testUserWithNoHeroCanCreateAHero()
    {
        static::bootKernel();
        $client = static::createClient();

        $user = $this->getUser('m1n0t4uR@gmail.com');
        $client->loginUser($user);

        $crawler = $client->request('GET', '/');

        $this->assertAnySelectorTextContains('div', 'You have no hero! Create one to get started');
        $this->assertAnySelectorTextContains('a', 'Create Hero');
    }

    public function testUserWithAHeroCannotCreateAHero()
    {
        static::bootKernel();
        $client = static::createClient();

        $user = $this->getUser('i_have_hero@gmail.com');
        $client->loginUser($user);

        $crawler = $client->request('GET', '/');

        $this->assertAnySelectorTextNotContains('div', 'You have no hero! Create one to get started');
        $this->assertAnySelectorTextNotContains('a', 'Create Hero');
        $this->assertAnySelectorTextContains('a', 'hero_name');
    }

    public function testUserOnHeroCreator()
    {
        static::bootKernel();
        $client = static::createClient();

        $user = $this->getUser('i_have_hero@gmail.com');
        $client->loginUser($user);

        $crawler = $client->request('GET', '/hero_creator');

        $this->assertAnySelectorTextContains('h1', 'Hero creator !');
    }

    private function getUser(string $email): UserInterface
    {
        $entityManager = self::$kernel->getContainer()->get('doctrine')->getManager();

        return $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
    }
}
