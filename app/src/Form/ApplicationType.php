<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Dealership;
use App\Entity\MailingAddress;
use App\Entity\TableAddOn;
use App\Entity\TableType;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends DealershipType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /**
         * @var Dealership $dealership
         */
        $dealership = $builder->getData();
        /**
         * @var User $user
         */
        $user = $dealership->getOwner();

        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Business Name: ',
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
                'businessEmail',
                TextType::class,
                [
                    'label' => 'Business Email: ',
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
                'businessPhone',
                TextType::class,
                [
                    'label' => 'Business Phone Number: ',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'label_attr' => [
                        'class' => 'form-label col-3 text-end fw-bold'
                    ]
                ]
            )
            ->add('MailAddress', EntityType::class, [
                'class' => MailingAddress::class,
                'choice_label' => 'nickname',
                'query_builder' => function(EntityRepository $er) use ($user): QueryBuilder {
                    return $er->createQueryBuilder('ma')
                        ->andWhere('ma.user = :user')
                        ->setParameter("user", $user);
                },
                'attr' => [
                    'class' => 'form-select address-target',
                ],
                'label_attr' => [
                    'class' => 'form-label col-3 text-end fw-bold'
                ],
                'label' => 'Business Address'
            ])
            ->add(
                'website',
                TextType::class,
                [
                    'label' => "Business Website: ",
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
                    'label' => "State Tax ID: ",
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'label_attr' => [
                        'class' => 'form-label col-3 text-end fw-bold'
                    ]
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'label' => 'Description of Business',
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
                'label' => 'Table Request (First Choice)',
                'required' => true,
                'class' => TableType::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-select',
                ],
                'label_attr' => [
                    'class' => 'form-label col-3 text-end fw-bold'
                ]
            ])
            ->add('tableRequestTypeSecond', EntityType::class, [
                'label' => 'Table Request (Second Choice)',
                'placeholder' => "",
                'required' => false,
                'class' => TableType::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-select',
                ],
                'label_attr' => [
                    'class' => 'form-label col-3 text-end fw-bold'
                ]
            ])
            ->add('tableRequestTypeThree', EntityType::class, [
                'label' => 'Table Request (Third Choice)',
                'placeholder' => "",
                'required' => false,
                'class' => TableType::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-select',
                ],
                'label_attr' => [
                    'class' => 'form-label col-3 text-end fw-bold'
                ]
            ])
            ->add('tableAddOn', EntityType::class, [
                'label' => 'Add Ons',
                'class' => TableAddOn::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'form-checkbox',
                ],
                'label_attr' => [
                    'class' => 'form-label col-3 text-end fw-bold'
                ]
            ])

            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'form-checkbox',
                ],
                'label_attr' => [
                    'class' => 'form-label col-3 text-end fw-bold'
                ]
            ])

        ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dealership::class,
        ]);
    }
}
