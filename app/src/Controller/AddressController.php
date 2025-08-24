<?php

namespace App\Controller;

use App\Entity\MailingAddress;
use App\Entity\User;
use App\Form\MailingAddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddressController extends AbstractController
{
    #[Route('/address/add', name: 'app_mailaddress_add')]
    public function addAddress(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /**
         * @var User $user
         */
        $user = $this->getUser();

        $address = new MailingAddress();
        $address->setUser($user);
        $addr = $request->request->all()['mailing_address'] ?? [];
        if (!empty($addr)) {
            $address->load($addr);
            $entityManager->persist($address);
            $entityManager->flush();
        }

        $addresses = $entityManager->getRepository(MailingAddress::class)->findBy(['user' => $user]);
        $output = [];
        foreach ($addresses as $a) {
            $output[] = [
                'id' => $a->getId(),
                'name' => $a->getNickname()
            ];
        }
        return new JsonResponse(['addresses' => $output]);

    }

}