<?php

namespace App\Form;

use App\Entity\DealerArea;
use App\Entity\TableType;
use App\Entity\Tag;
use App\Entity\User;
use App\Entity\VoteEvent;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoteEventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('votesPerCurator')
            ->add('startTime')
            ->add('endTime')
            ->add('isActive')
            ->add('createdOn')
            ->add('maxCuratorVotesPerApplicant')
            ->add('sqlQuery')
            ->add('addedBy', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('filterByArea', EntityType::class, [
                'class' => DealerArea::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('filterByTableType', EntityType::class, [
                'class' => TableType::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('filterByTag', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VoteEvent::class,
        ]);
    }
}
