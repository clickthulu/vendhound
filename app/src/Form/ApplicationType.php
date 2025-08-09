<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Dealership;
use App\Entity\MailingAddress;
use App\Entity\TableType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Dealership Name: ',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'label_attr' => [
                        'class' => 'form-label col-3 text-end fw-bold'
                    ]
                ]
            )
            ->add(
                'taxID',
                TextType::class,
                [
                    'label' => "Tax ID: ",
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'label_attr' => [
                        'class' => 'form-label col-3 text-end fw-bold'
                    ]
                ]
            )
            ->add(
                'productsAndServices',
                TextareaType::class,
                [
                    'label' => 'Products and Services',
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'label_attr' => [
                        'class' => 'form-label col-3 text-end fw-bold'
                    ]
                ]
            )
            ->add('tableRequestType', EntityType::class, [
                'class' => TableType::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-select',
                ],
                'label_attr' => [
                    'class' => 'form-label col-3 text-end fw-bold'
                ]
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'attr' => [
                    'class' => 'form-select',
                ],
                'label_attr' => [
                    'class' => 'form-label col-3 text-end fw-bold'
                ]
            ])
            ->add('MailAddress', EntityType::class, [
                'class' => MailingAddress::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dealership::class,
        ]);
    }
}
