<?php

namespace App\Form;

use App\Entity\DealerArea;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DealerAreaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',
                TextType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'required' => true
                    ],
                    'label' => 'New Area:',
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
            'data_class' => DealerArea::class,
        ]);
    }
}
