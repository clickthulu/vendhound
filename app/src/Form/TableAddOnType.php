<?php

namespace App\Form;

use App\Entity\TableAddOn;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TableAddOnType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'required' => true
                    ],
                    'label' => 'Name:',
                    'label_attr' => [
                        'class' => 'form-label col-3 text-end fw-bold'
                    ]
                ])
            ->add('description',
                TextareaType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'required' => true
                    ],
                    'label' => 'Description:',
                    'label_attr' => [
                        'class' => 'form-label col-3 text-end fw-bold'
                    ]
                ])
            ->add(
                'additionalCost',
                NumberType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'required' => true
                    ],
                    'label' => 'Additional Cost:',
                    'label_attr' => [
                        'class' => 'form-label col-3 text-end fw-bold'
                    ]
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TableAddOn::class,
        ]);
    }
}
