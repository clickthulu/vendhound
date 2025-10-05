<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\VendorImportMap;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VendorImportFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'importfile',
                FileType::class,
                [
                    'attr' => [
                        'class' => 'form-control col-1',
                        'required' => true
                    ],
                    'label' => 'Import File:',
                    'label_attr' => [
                        'class' => 'form-label col-3 text-end fw-bold'
                    ]
                ]

            )
            ->add('categories', EntityType::class, [
                'class' => VendorImportMap::class,
                'choice_label' => 'name',
                'multiple' => false,
                'placeholder' => 'Create New Map'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
