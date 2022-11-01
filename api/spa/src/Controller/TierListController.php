<?php

namespace App\Controller;

use App\Entity\TierList;
use App\Repository\TierListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/tier_lists')]
class TierListController extends AbstractController
{
    public function __construct(readonly private SerializerInterface $serializer)
    {
    }

    #[Route('', name: 'app_tier_list_index', methods: ['GET'])]
    public function index(TierListRepository $tierListRepository): JsonResponse
    {
        $tierLists = $tierListRepository->findAll();

        return new JsonResponse($this->serializer->serialize($tierLists, 'json', ['groups' => 'tier_list']));
    }

    #[Route('/{id}', name: 'app_tier_list_show', methods: ['GET'])]
    public function show(TierList $tierList): JsonResponse
    {
        return new JsonResponse($this->serializer->serialize($tierList, 'json', ['groups' => 'tier_list']));
    }
}
