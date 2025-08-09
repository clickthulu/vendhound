<?php

namespace App\Form;

use App\Entity\Dealership;
use App\Entity\MailingAddress;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailingAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('street1')
            ->add('street2')
            ->add('street3')
            ->add('city')
            ->add('province')
            ->add('postalCode')
            ->add('country')
            ->add('dealership', EntityType::class, [
                'class' => Dealership::class,
                'choice_label' => 'id',
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
