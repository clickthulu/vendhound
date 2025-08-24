<?php

namespace App\Form;

use App\Entity\Dealership;
use App\Entity\MailingAddress;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailingAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nickname',
                TextType::class,
                [
                    'label' => 'Address Name: ',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control mailaddress-input',
                    ],
                    'label_attr' => [
                        'class' => 'form-label col-3 text-end fw-bold'
                    ]
                ])
            ->add('street1',
                TextType::class,
                [
                    'label' => 'Street: ',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control mailaddress-input',
                    ],
                    'label_attr' => [
                        'class' => 'form-label col-3 text-end fw-bold'
                    ]
                ])
            ->add('street2',
                TextType::class,
                [
                    'label' => 'Street 2: ',
                    'attr' => [
                        'class' => 'form-control mailaddress-input',
                    ],
                    'label_attr' => [
                        'class' => 'form-label col-3 text-end fw-bold'
                    ]
                ])
            ->add('city',
                TextType::class,
                [
                    'label' => 'City: ',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control mailaddress-input',
                    ],
                    'label_attr' => [
                        'class' => 'form-label col-3 text-end fw-bold'
                    ]
                ])
            ->add('province',
                TextType::class,
                [
                    'label' => 'State/Province: ',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control mailaddress-input',
                    ],
                    'label_attr' => [
                        'class' => 'form-label col-3 text-end fw-bold'
                    ]
                ])
            ->add('postalCode',
                TextType::class,
                [
                    'label' => 'Postal Code: ',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control mailaddress-input',
                    ],
                    'label_attr' => [
                        'class' => 'form-label col-3 text-end fw-bold'
                    ]
                ])
            ->add('country',
                TextType::class,
                [
                    'label' => 'Country: ',
                    'attr' => [
                        'class' => 'form-control mailaddress-input',
                    ],
                    'label_attr' => [
                        'class' => 'form-label col-3 text-end fw-bold'
                    ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MailingAddress::class,
        ]);
    }
}
