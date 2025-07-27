<?php

namespace App\Form;

use App\Entity\TableType;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TableTypeForm extends AbstractType
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
                ]
            )
            ->add(
                'width',
                NumberType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'required' => true
                    ],
                    'label' => 'Width:',
                    'label_attr' => [
                        'class' => 'form-label col-3 text-end fw-bold'
                    ]
                ]
            )
            ->add(
                'depth',
                NumberType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'required' => true
                    ],
                    'label' => 'Depth:',
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
            'data_class' => TableType::class,
        ]);
    }
}
