<?php

namespace App\Controller;
use App\Entity\TableType;
use App\Entity\User;
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
        return $this->render(
                    'admin/define-table-type.html.twig',
                    [
                        'TableTypeForm' => $form->createView()
                    ]
                );
    }
}
