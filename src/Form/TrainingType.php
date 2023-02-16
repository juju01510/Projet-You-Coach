<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\Training;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $idClub = $options['idClub'];

        $builder
            ->add('date', DateTimeType::class, [
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'attr' => [
                    'placeholder' => 'Date'
                ],
            ])
            ->add('place', TextType::class, [
                'attr' => [
                    'placeholder' => 'Lieu'
                ]
            ])
            ->add('info', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Informations complémentaires'
                ]
            ])
            ->add('team', EntityType::class, [
                'required' => true,
                'label' => 'Équipe',
                'class' => Team::class,
                'query_builder' => function (EntityRepository $er) use ($idClub) {
                    return $er->createQueryBuilder('t')
                        ->where('t.club = :club')
                        ->setParameter('club', $idClub)
                        ->orderBy('t.category', 'DESC');
                },
                'choice_label' => function ($team) {
                    return $team->getClub()->getName() . ' - ' . $team->getCategory() . ' - ' . $team->getLevel();
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['idClub']);
        $resolver->setDefaults([
            'data_class' => Training::class,
        ]);
    }
}
