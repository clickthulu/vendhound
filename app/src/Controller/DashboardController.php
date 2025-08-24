<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\DealerArea;
use App\Entity\TableAddOn;
use App\Entity\TableType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        return $this->render('dashboard/index.html.twig', [
            'roles' => $user->getRoles(),
            'validated' => $this->validatePrep($entityManager)
        ]);
    }



    #[Route('/left-blank', name: 'app_none')]
    public function deliberatelyBlank(): Response
    {
        return $this->render('dashboard/no-page.html.twig');
    }

    protected function validatePrep(EntityManagerInterface $entityManager): array
    {
        // Go through the various prep tables to see if they've been set up

        return [
            'tabletype' => $entityManager->getRepository(TableType::class)->count() > 0,
            'tableaddon' => $entityManager->getRepository(TableAddOn::class)->count() > 0,
            'dealerarea' => $entityManager->getRepository(DealerArea::class)->count() > 0,
            'category' => $entityManager->getRepository(Category::class)->count() > 0,
        ];


    }
}
