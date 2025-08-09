<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Dealership;
use App\Entity\MailingAddress;
use App\Entity\TableType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DealershipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('taxID')
            ->add('productsAndServices')
            ->add('createdOn')
            ->add('isAccepted')
            ->add('isPaid')
            ->add('tableRequestType', EntityType::class, [
                'class' => TableType::class,
                'choice_label' => 'id',
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'id',
                'multiple' => true,
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
