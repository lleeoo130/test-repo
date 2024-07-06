<?php

namespace App\Tests;

use App\Entity\Maze;
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

        $this->assertSelectorTextSame('a', 'create maze');
    }

    public function testAdminCanGoToMazeCreationPage(): void
    {
        $crawler = $this->client->request('GET', '/admin/maze_creator');

        $this->assertAnySelectorTextContains('h1', 'Maze Creation');
        $this->assertAnySelectorTextContains('p', 'create your maze');

        $this->assertFormValue('#maze_submit', 'maze[width]', 3);
        $this->assertFormValue('#maze_submit', 'maze[height]', 3);
    }

    public function testAdminCanGoToMazeConfigurationPage(): void
    {
        $maze = $this->getMaze();

        $crawler = $this->client->request('GET', '/admin/maze_configuration/' . $maze[0]->getId());

        $this->assertAnySelectorTextContains('h1', 'Maze Configuration');

        $this->assertFormValue('#maze_configuration_submit', 'maze.configuration_1_1', 'empty');
        $this->assertFormValue('#maze_configuration_submit', 'maze.configuration_1_2', 'empty');
        $this->assertFormValue('#maze_configuration_submit', 'maze.configuration_1_3', 'empty');
        $this->assertFormValue('#maze_configuration_submit', 'maze.configuration_2_1', 'empty');
        $this->assertFormValue('#maze_configuration_submit', 'maze.configuration_2_2', 'empty');
        $this->assertFormValue('#maze_configuration_submit', 'maze.configuration_2_3', 'empty');
        $this->assertFormValue('#maze_configuration_submit', 'maze.configuration_3_1', 'empty');
        $this->assertFormValue('#maze_configuration_submit', 'maze.configuration_3_2', 'empty');
        $this->assertFormValue('#maze_configuration_submit', 'maze.configuration_3_3', 'empty');
    }

    private function getMaze()
    {
        $entityManager = self::$kernel->getContainer()->get('doctrine')->getManager();

        return $entityManager->getRepository(Maze::class)->findAll();
    }
}
