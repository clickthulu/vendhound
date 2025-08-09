<?php

namespace App\Controller;

use App\Entity\Dealership;
use App\Entity\User;
use App\Form\ApplicationType;
use App\Form\DealershipType;
use App\Form\TableTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class DealershipController extends AbstractController
{

    #[Route('/apply', name: 'app_dealership_apply')]
    public function apply(Request $request, EntityManagerInterface $entityManager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /**
         * @var User $user
         */
        $user = $this->getUser();

        $dealership = new Dealership();
        // here's where we build a dealership application form
        $form = $this->createForm(ApplicationType::class, $dealership);
        $form->handleRequest($request);

        try {
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($dealership);
                $entityManager->flush();
                return new RedirectResponse($this->generateUrl('app_dashboard'));
            }
        } catch (Exception $e){
            $err = new FormError($e->getMessage());
            $form->addError($err);
        }
        return $this->render(
            'dashboard/application.html.twig',
            [
                'applicationForm' => $form->createView(),
            ]
        );

    }


}