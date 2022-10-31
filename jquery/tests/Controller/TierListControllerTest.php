<?php

namespace App\Test\Controller;

use App\Entity\TierList;
use App\Repository\TierListRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TierListControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private TierListRepository $repository;
    private string $path = '/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(TierList::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('TierList index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = \count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'tier_list[name]' => 'Testing',
            'tier_list[description]' => 'Testing',
            'tier_list[createdAt]' => 'Testing',
            'tier_list[updatedAt]' => 'Testing',
        ]);

        self::assertResponseRedirects('/tier/list/');

        self::assertSame($originalNumObjectsInRepository + 1, \count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new TierList();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('TierList');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new TierList();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'tier_list[name]' => 'Something New',
            'tier_list[description]' => 'Something New',
            'tier_list[createdAt]' => 'Something New',
            'tier_list[updatedAt]' => 'Something New',
        ]);

        self::assertResponseRedirects('/tier/list/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = \count($this->repository->findAll());

        $fixture = new TierList();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, \count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, \count($this->repository->findAll()));
        self::assertResponseRedirects('/tier/list/');
    }
}
