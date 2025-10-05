<?php

namespace App\Controller;
use App\Entity\DealerArea;
use App\Entity\Dealership;
use App\Entity\TableAddOn;
use App\Entity\TableType;
use App\Entity\User;
use App\Entity\Category;
use App\Enumerations\UserRole;
use App\Exception\RoleNotFoundException;
use App\Form\CategoryTypeForm;
use App\Form\DealerAreaType;
use App\Form\TableAddOnType;
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

    #[Route('/admin/table-addon', name: 'app_admin_tableaddon')]
    public function listTableAddon(Request $request, EntityManagerInterface $entityManager): Response
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

        $tableAddons = $entityManager->getRepository(TableAddOn::class)->findBy([], ['name' => 'ASC']);

        return $this->render('admin/table-addon.html.twig', [
            'tableAddons' => $tableAddons
        ]);

    }


    #[Route('/admin/table-addon/edit/{id}', name: 'app_admin_tableaddonedit')]
    #[Route('/admin/table-addon/create', name: 'app_admin_tableaddoncreate')]
    public function defineTableAddon(Request $request, EntityManagerInterface $entityManager, ?int $id = null): Response
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
        $tableAddon = new TableAddOn();
        $action = 'created';

        if (!empty($id)) {
            $tableAddon = $entityManager->getRepository(TableAddOn::class)->find($id);
            $action = 'updated';
        }

        $form = $this->createForm(TableAddOnType::class, $tableAddon);
        $form->handleRequest($request);
        try {
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($tableAddon);
                $entityManager->flush();
                $this->addFlash('info', "Table addon {$tableAddon->getName()} has been {$action}");
                return new RedirectResponse($this->generateUrl('app_admin_tableaddon'));
            }
        } catch (Exception $e) {
            $err = new FormError($e->getMessage());
            $form->addError($err);
        }
        return $this->render(
            'admin/define-table-addon.html.twig',
            [
                'tableAddonForm' => $form->createView(),
            ]
        );
    }

    #[Route('/admin/table-addon/delete/{id}', name: 'app_admin_tableaddondelete')]
    public function deleteTableAddon(EntityManagerInterface $entityManager, string $id): RedirectResponse
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
         * @var TableType $tableAddon
         */
        $tableAddon = $entityManager->getRepository(TableType::class)->find($id);

        $entityManager->remove($tableAddon);
        $entityManager->flush();
        return new RedirectResponse($this->generateUrl('app_admin_tableaddon'));
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

    #[Route('/admin/users', name: 'app_admin_userlist')]
    public function userList(EntityManagerInterface $entityManager): Response
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

        $users = $entityManager->getRepository(User::class)->findBy([], ['email' => 'ASC']);

        return $this->render("/admin/user-list.html.twig", [ 'users' => $users ]);


    }

    #[Route('/admin/users/role/{id}/{role}', name: 'app_admin_toggleuserrole')]
    public function toggleRole(EntityManagerInterface $entityManager, int $id, string $role): Response
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

        $currentuser = $entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
        $roles = $currentuser->getRoles();
        try {
            $role = UserRole::normalize($role);
            if (in_array($role, $roles)) {
                // remove role from user
                $currentuser->removeRole($role);
            } else {
                // add role to user
                $currentuser->addRole($role);
            }
            $entityManager->persist($currentuser);
            $entityManager->flush();

        } catch (RoleNotFoundException) {

        }


        return new RedirectResponse($this->generateUrl('app_admin_userlist'));


    }

    #[Route('/admin/users/edit/{id}', name: 'app_admin_useredit')]
    public function userEdit(EntityManagerInterface $entityManager, int $id): Response
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

        return $this->render("/intentional-blank.html.twig");


    }

    #[Route('/admin/users/delete/{id}', name: 'app_admin_userdelete')]
    public function userDelete(EntityManagerInterface $entityManager, int $id): Response
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

        return $this->render("/intentional-blank.html.twig");


    }


}
