<?php

namespace App\Controller;

use App\Entity\TierList;
use App\Form\TierListType;
use App\Repository\TierListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TierListController extends AbstractController
{
    #[Route('/', name: 'app_tier_list_index', methods: ['GET'])]
    public function index(TierListRepository $tierListRepository): Response
    {
        return $this->render('tier_list/index.html.twig', [
            'tier_lists' => $tierListRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tier_list_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TierListRepository $tierListRepository): Response
    {
        $tierList = new TierList();
        $form = $this->createForm(TierListType::class, $tierList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tierListRepository->save($tierList, true);

            return $this->redirectToRoute('app_tier_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tier_list/new.html.twig', [
            'tier_list' => $tierList,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tier_list_show', methods: ['GET'])]
    public function show(TierList $tierList): Response
    {
        return $this->render('tier_list/show.html.twig', [
            'tier_list' => $tierList,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tier_list_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TierList $tierList, TierListRepository $tierListRepository): Response
    {
        $form = $this->createForm(TierListType::class, $tierList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tierListRepository->save($tierList, true);

            return $this->redirectToRoute('app_tier_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tier_list/edit.html.twig', [
            'tier_list' => $tierList,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tier_list_delete', methods: ['POST'])]
    public function delete(Request $request, TierList $tierList, TierListRepository $tierListRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tierList->getId(), $request->request->get('_token'))) {
            $tierListRepository->remove($tierList, true);
        }

        return $this->redirectToRoute('app_tier_list_index', [], Response::HTTP_SEE_OTHER);
    }
}
