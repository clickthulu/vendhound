<?php

namespace App\Controller;
use App\Entity\DealerArea;
use App\Entity\Dealership;
use App\Entity\TableType;
use App\Entity\User;
use App\Entity\Category;
use App\Form\CategoryTypeForm;
use App\Form\DealerAreaType;
use App\Form\TableTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AdminController extends AbstractController
{

    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/category', name: 'app_admin_category')]
    public function categories(Request $request, EntityManagerInterface $entityManager): Response
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

        $item = new Category();
        $form = $this->createForm(CategoryTypeForm::class, $item);
        $form->handleRequest($request);

        try {
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($item);
                $entityManager->flush();
                $this->addFlash('info', "{$item->getName()} added as a new category");
                return new RedirectResponse($this->generateUrl('app_admin_category'));
            }
        } catch (\Exception $e) {
            $this->addFlash('danger', "An error has occured: {$e->getMessage()}");
        }

        $categories = $entityManager->getRepository(Category::class)->findBy([], ['name' => 'ASC']);

        return $this->render('admin/category.html.twig', [
            'categoryForm' => $form->createView(),
            'categories' => $categories
        ]);
    }

    #[Route('/admin/category/delete/{id}', name: 'app_admin_categorydelete')]
    public function deleteCategory(EntityManagerInterface $entityManager, string $id): RedirectResponse
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

        /**
         * @var Category $category
         */
        $category = $entityManager->getRepository(Category::class)->find($id);

        $entityManager->remove($category);
        $entityManager->flush();
        return new RedirectResponse($this->generateUrl('app_admin_category'));
    }

    #[Route('/admin/table-type', name: 'app_admin_tabletype')]
    public function listTableType(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tableTypes = $entityManager->getRepository(TableType::class)->findBy([], ['name' => 'ASC']);

        return $this->render('admin/table-type.html.twig', [
            'tableTypes' => $tableTypes
        ]);

    }

    #[Route('/admin/table-type/edit/{id}', name: 'app_admin_tabletypeedit')]
    #[Route('/admin/table-type/create', name: 'app_admin_tabletypecreate')]
    public function defineTableType(Request $request, EntityManagerInterface $entityManager, ?int $id = null): Response
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
        $tableType = new TableType();
        $action = 'created';

        if (!empty($id)) {
            $tableType = $entityManager->getRepository(TableType::class)->find($id);
            $action = 'updated';
        }

        $form = $this->createForm(TableTypeForm::class, $tableType);
        $form->handleRequest($request);
        try {
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($tableType);
                $entityManager->flush();
                $this->addFlash('info', "Table type {$tableType->getName()} has been {$action}");
                return new RedirectResponse($this->generateUrl('app_admin_tabletype'));
            }
        } catch (Exception $e) {
            $err = new FormError($e->getMessage());
            $form->addError($err);
        }
        return $this->render(
            'admin/define-table-type.html.twig',
            [
                'tableTypeForm' => $form->createView(),
            ]
        );
    }

    #[Route('/admin/table-type/delete/{id}', name: 'app_admin_tabletypedelete')]
    public function deleteTableType(EntityManagerInterface $entityManager, string $id): RedirectResponse
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

        /**
         * @var TableType $tableType
         */
        $tableType = $entityManager->getRepository(TableType::class)->find($id);

        $entityManager->remove($tableType);
        $entityManager->flush();
        return new RedirectResponse($this->generateUrl('app_admin_tabletype'));
    }

    #[Route('/admin/dealer-area', name: 'app_admin_dealerarea')]
    public function listDealerArea(Request $request, EntityManagerInterface $entityManager): Response
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

        $area = new DealerArea();
        $form = $this->createForm(DealerAreaType::class, $area);
        $form->handleRequest($request);

        try {
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($area);
                $entityManager->flush();
                $this->addFlash('info', "{$area->getName()} added as a new area");
                return new RedirectResponse($this->generateUrl('app_admin_dealerarea'));
            }
        } catch (\Exception $e) {
            $this->addFlash('danger', "An error has occured: {$e->getMessage()}");
        }

        $dealerAreas = $entityManager->getRepository(DealerArea::class)->findBy([], ['name' => 'ASC']);

        return $this->render('admin/dealer-area.html.twig', [
            'dealerareas' => $dealerAreas,
            'dealerareaForm' => $form->createView()
        ]);

    }

    #[Route('/admin/dealer-area/delete/{id}', name: 'app_admin_dealerareadelete')]
    public function deleteDealerArea(EntityManagerInterface $entityManager, string $id): RedirectResponse
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

        /**
         * @var DealerArea $area
         */
        $area = $entityManager->getRepository(DealerArea::class)->find($id);

        $entityManager->remove($area);
        $entityManager->flush();
        return new RedirectResponse($this->generateUrl('app_admin_dealerarea'));
    }



    #[Route('/admin/dealership/deleteall', name: 'app_admin_deleteallvendors')]
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

    #[Route('/admin/dealership/deleteall/confirm', name: 'app_admin_deleteallvendorsconfirm')]
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

    #[Route('/admin/vote_event', name: 'app_admin_vote_event')]
        public function listVoteEvent(Request $request, EntityManagerInterface $entityManager): Response
        {
            $voteEvents = $entityManager->getRepository(VoteEvent::class)->findBy([], ['name' => 'ASC']);

            return $this->render('admin/vote_event.html.twig', [
                'voteEvents' => $voteEvents
            ]);

        }

        #[Route('/admin/vote_event/edit/{id}', name: 'app_admin_vote_event_edit')]
        #[Route('/admin/vote_event/create', name: 'app_admin_vote_event_create')]
        public function defineVoteEvent(Request $request, EntityManagerInterface $entityManager, ?int $id = null): Response
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
            $voteEvent = new VoteEvent();
            $action = 'created';

            if (!empty($id)) {
                $voteEvent = $entityManager->getRepository(VoteEvent::class)->find($id);
                $action = 'updated';
            }

            $form = $this->createForm(VoteEventFormType::class, $voteEvent);
            $form->handleRequest($request);
            try {
                if ($form->isSubmitted() && $form->isValid()) {
                    $entityManager->persist($voteEvent);
                    $entityManager->flush();
                    $this->addFlash('info', "Vote event {$voteEvent->getId()} has been {$action}");
                    return new RedirectResponse($this->generateUrl('app_admin_vote_event'));
                }
            } catch (Exception $e) {
                $err = new FormError($e->getMessage());
                $form->addError($err);
            }
            return $this->render(
                'admin/define_vote_event.html.twig',
                [
                    'VoteEventFormType' => $form->createView(),
                ]
            );
        }

        #[Route('/admin/vote_event/delete/{id}', name: 'app_admin_vote_event_delete')]
        public function deleteVoteEvent(EntityManagerInterface $entityManager, string $id): RedirectResponse
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

            /**
             * @var VoteEvent $voteEvent
             */
            $voteEvent = $entityManager->getRepository(VoteEvent::class)->find($id);

            $entityManager->remove($voteEvent);
            $entityManager->flush();
            return new RedirectResponse($this->generateUrl('app_admin_vote_event'));
        }

}
