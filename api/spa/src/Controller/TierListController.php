<?php

namespace App\Controller;

use App\Repository\TierListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/tier_lists')]
class TierListController extends AbstractController
{
    public function __construct(private readonly SerializerInterface $serializer, private readonly TierListRepository $tierListRepository)
    {
    }

    #[Route('', name: 'app_tier_list_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $tierLists = $this->tierListRepository->findAll();

        return new JsonResponse($this->serializer->serialize($tierLists, 'json', ['groups' => 'tier_list']));
    }

    #[Route('/{id}', name: 'app_tier_list_show', methods: ['GET'])]
    public function show(string $id): JsonResponse
    {
        $tierList = $this->tierListRepository->find($id);

        if (null !== $tierList) {
            return new JsonResponse($this->serializer->serialize($tierList, 'json', ['groups' => 'tier_list']));
        }

        return new JsonResponse(['code' => 404, 'error' => 'Tier list not found.'], 404);
    }
}
