<?php

namespace App\Controller;

use App\Entity\Settings;
use App\Entity\SettingsCollection;
use App\Entity\User;
use App\Form\SettingsType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SettingsController extends AbstractController
{

    #[Route('/admin/settings', name: 'app_settings')]
    public function manageSettings(EntityManagerInterface $entityManager, Request $request): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /**
         * @var User $user
         */
        $user = $this->getUser();
        if (!in_array("ROLE_OWNER", $user->getRoles()) && !in_array("ROLE_ADMIN", $user->getRoles())) {
            $this->addFlash('error', 'You do not have permission to perform this action');
            return new RedirectResponse($this->generateUrl("app_dashboard"), 403);
        }

        $items = $entityManager->getRepository(Settings::class)->findAll();
        $settingsCollection = new SettingsCollection();
        /**
         * @var Settings $item
         */
        foreach ($items as $item) {
            $settingsCollection->addItem($item);
        }
        $form = $this->createForm(SettingsType::class, $settingsCollection);
        $form->handleRequest($request);

        try {
            if ($form->isSubmitted() && $form->isValid()) {
                /**
                 * @var Settings $item
                 */
                foreach ($settingsCollection->getItems() as $item) {
                    $entityManager->persist($item);
                }
                $entityManager->flush();
                $this->addFlash('info', 'Settings have been updated');
                return new RedirectResponse($this->generateUrl('app_settings'));
            }
        } catch (Exception $e){
            $err = new FormError($e->getMessage());
            $form->addError($err);
        }



        return $this->render(
            'admin/settings.html.twig',
            [
                'settingsForm' => $form->createView()
            ]
        );
    }

}