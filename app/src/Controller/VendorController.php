<?php

namespace App\Controller;

use App\Entity\Dealership;
use App\Entity\User;
use App\Form\ApplicationType;
use App\Form\MailingAddressType;
use App\Form\VendorImportFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VendorController extends AbstractController
{



    #[Route('/admin/vendor', name: 'app_vendor_list')]
    public function vendorList(EntityManagerInterface $entityManager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /**
         * @var User $user
         */
        $user = $this->getUser();
        if (!in_array("ROLE_DEVELOPER", $user->getRoles()) && !in_array("ROLE_ADMIN", $user->getRoles())) {
            $this->addFlash('error', 'You do not have permission to perform this action');
            return new RedirectResponse($this->generateUrl("app_dashboard"), 403);
        }

        $vendors = $entityManager->getRepository(Dealership::class)->findBy([], ['name' => 'asc']);

        return $this->render('vendor/vendor-list.html.twig', ['vendors' => $vendors]);
    }


    #[Route('/admin/vendor/import', name: 'app_vendor_import')]
    public function vendorImport(Request $request, EntityManagerInterface $entityManager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /**
         * @var User $user
         */
        $user = $this->getUser();
        if (!in_array("ROLE_DEVELOPER", $user->getRoles()) && !in_array("ROLE_ADMIN", $user->getRoles())) {
            $this->addFlash('error', 'You do not have permission to perform this action');
            return new RedirectResponse($this->generateUrl("app_dashboard"), 403);
        }

        $form = $this->createForm(VendorImportFormType::class);
        $form->handleRequest($request);
        try {
            if ($form->isSubmitted() && $form->isValid()) {
                $vendorImportMap = $form->getData();
                // Get the map.  If the map does not exist, go to the "Create Map" form using the form file as the basis.
                dd($form);

                return new RedirectResponse($this->generateUrl('app_dashboard'));
            }
        } catch (\Exception $e){
            $err = new FormError($e->getMessage());
            $form->addError($err);
        }

        return $this->render('vendor/vendor-import.html.twig', ['vendorimportform' => $form->createView()]);
    }


    #[Route('/admin/vendor/deleteall', name: 'app_admin_deleteallvendors')]
    public function deleteAllDealerships(EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /**
         * @var User $user
         */
        $user = $this->getUser();
        if (!in_array("ROLE_DEVELOPER", $user->getRoles()) && !in_array("ROLE_ADMIN", $user->getRoles())) {
            $this->addFlash('error', 'You do not have permission to perform this action');
            return new RedirectResponse($this->generateUrl("app_dashboard"), 403);
        }

        return $this->render("admin//dealer-delete-all.html.twig");
    }

    #[Route('/admin/vendor/deleteall/confirm', name: 'app_admin_deleteallvendorsconfirm')]
    public function deleteAllDealershipsConfirm(EntityManagerInterface $entityManager): RedirectResponse
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /**
         * @var User $user
         */
        $user = $this->getUser();
        if (!in_array("ROLE_DEVELOPER", $user->getRoles()) && !in_array("ROLE_ADMIN", $user->getRoles())) {
            $this->addFlash('error', 'You do not have permission to perform this action');
            return new RedirectResponse($this->generateUrl("app_dashboard"), 403);
        }
        $dql = "DELETE FROM App\Entity\Dealership";
        $query = $entityManager->createQuery($dql);
        $deleted = $query->execute();
        $this->addFlash("warning", "{$deleted} dealerships have been removed from the table.");
        return new RedirectResponse($this->generateUrl('app_dashboard'));
    }


}