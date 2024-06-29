<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Component\Panther\PantherTestCase;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminTest extends PantherTestCase
{
    /** @var \Symfony\Bundle\FrameworkBundle\KernelBrowser */
    private $client;

    public function setUp(): void
    {
        static::bootKernel();
        $this->client = static::createClient();

        $user = $this->getUser('m1n0t4uR@gmail.com');

        $this->client->loginUser($user);
    }

    public function testIsAdmin(): void
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertAnySelectorTextContains('h1', 'Hello m1n0t4uR !');
        $this->assertAnySelectorTextContains('a', 'admin dashboard');
    }

    private function getUser(string $email): UserInterface
    {
        $entityManager = self::$kernel->getContainer()->get('doctrine')->getManager();

        return $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
    }

    public function testAdminDashboard(): void
    {
        $crawler = $this->client->request('GET', '/admin');

        $this->assertAnySelectorTextContains('h1', 'Hello Admin m1n0t4uR !');
        $this->assertAnySelectorTextContains('a', 'manage mazes');
    }

    public function testAdminCanGoToMazeManagementPage(): void
    {
        $crawler = $this->client->request('GET', '/admin/mazes');

        $this->assertAnySelectorTextContains('h1', 'Mazes Management');
        $this->assertAnySelectorTextContains('p', 'You have no maze');

        $this->assertSelectorTextSame('a', 'create maze');
    }

    public function testAdminCanGoToMazeCreationPage(): void
    {
        $crawler = $this->client->request('GET', '/admin/mazes_creator');

        $this->assertAnySelectorTextContains('h1', 'Maze Creation');
        $this->assertAnySelectorTextContains('p', 'create your maze');
    }
}
