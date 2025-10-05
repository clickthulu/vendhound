<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

/**
 * This particular set of methods are specific to when the system is in development mode.  Do not
 * put anything that would need to go to production, and make sure that it checks the env before it runs
 * otherwise there will be grumpyness
 */


class DeveloperController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('/developer/flashTest', name: 'app_developer_flashtest')]
    public function flashTest(ParameterBagInterface $parameterBag, EntityManagerInterface $entityManager)
    {

        $this->addFlash('success', 'SUCCESS This will only work in developer mode');
        $this->addFlash('info', 'INFO This will only work in developer mode');
        $this->addFlash('warning', 'WARNING This will only work in developer mode');
        $this->addFlash('danger', 'ERROR This will only work in developer mode');

        return new RedirectResponse($this->generateUrl('app_dashboard'));
    }

    #[Route('/developer/promoteToAdmin/{role}', name: 'app_developer_promoteme')]
    public function makeMeAdminstrator(ParameterBagInterface $parameterBag, EntityManagerInterface $entityManager, string $role = "ROLE_ADMIN" )
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $env = $parameterBag->get('app.environment');
        if (strtoupper($env) !== 'DEV') {
            $this->addFlash('success', 'This will only work in developer mode');
            return new RedirectResponse($this->generateUrl('app_dashboard'), 404);
        }
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $roles = $user->getRoles();
        $roles[] = $role;
        $roles = array_unique($roles);
        $user->setRoles($roles);
        $entityManager->persist($user);
        $entityManager->flush();
        $this->addFlash('success', 'You have been granted god like powers');
        return new RedirectResponse($this->generateUrl('app_dashboard'));
    }

}