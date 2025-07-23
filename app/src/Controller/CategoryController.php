<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\User;
use App\Form\CategoryTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

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

        $categories = $entityManager->getRepository(Category::class)->findAll();

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

}