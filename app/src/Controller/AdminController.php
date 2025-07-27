<?php

namespace App\Controller;
use App\Entity\TableType;
use App\Entity\User;
use App\Entity\Category;
use App\Form\CategoryTypeForm;
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
        if (!in_array("ROLE_OWNER", $user->getRoles()) && !in_array("ROLE_ADMIN", $user->getRoles())) {
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
        if (!in_array("ROLE_OWNER", $user->getRoles()) && !in_array("ROLE_ADMIN", $user->getRoles())) {
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

    #[Route('/admin/define-table-type', name: 'define-table-type')]
    public function defineTableType(Request $request , EntityManagerInterface $entityManager): Response
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
                $tableType = new TableType();
                $form = $this->createForm(TableTypeForm::class, $tableType);
                $form->handleRequest($request);
                try {
                            if ($form->isSubmitted() && $form->isValid()) {

                                    $entityManager->persist($tableType);

                                $entityManager->flush();
                                $this->addFlash('info', 'Table type has been updated');
                                return new RedirectResponse($this->generateUrl('table-types-list'));
                            }
                        } catch (Exception $e){
                            $err = new FormError($e->getMessage());
                            $form->addError($err);
                        }
        $tableTypes = $entityManager->getRepository(TableType::class)->findAll();

        return $this->render(
                    'admin/define-table-type.html.twig',
                    [
                        'tableTypeForm' => $form->createView(),
                        'tableTypes' => $tableTypes
                    ]
                );
    }
    #[Route('/admin/tableType/delete/{id}', name: 'app_admin_table_type_delete')]
    public function deleteTableType(EntityManagerInterface $entityManager, string $id): RedirectResponse
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

        /**
         * @var TableType $tableType
         */
        $tableType = $entityManager->getRepository(TableType::class)->find($id);

        $entityManager->remove($tableType);
        $entityManager->flush();
        return new RedirectResponse($this->generateUrl('define-table-type'));
    }
}
