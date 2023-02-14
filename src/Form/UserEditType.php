<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $idClub = $options['idClub'];

        $builder
            ->add('firstname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Prénom'
                ],
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom'
                ],
            ])
            ->add('email', TextType::class, [
                'attr' => [
                    'placeholder' => 'Email'
                ],
            ])
            ->add('phone', TextType::class, [
                'attr' => [
                    'placeholder' => 'Téléphone'
                ],
            ])
//            ->add('roles', ChoiceType::class, [
//                'attr' => ['placeholder' => 'ROLE'],
//                'required' => false,
//                'multiple' => false,
//                'expanded' => false,
//                'choices' => [
//                    'Joueur' => 'ROLE_PLAYER',
//                    'Coach' => 'ROLE_COACH',
//                ],
//                'choice_attr' => [
//                    'Joueur' => ['class' => 'roles'],
//                    'Coach' => ['class' => 'roles'],
//                ]
//            ])
            ->add('team', EntityType::class, [
                'attr' => ['placeholder' => 'Equipe'],
                'required' => false,
                'label' => 'Choisir un type',
                'class' => Team::class,
                'query_builder' => function (EntityRepository $er) use ($idClub) {
                    return $er->createQueryBuilder('t')
                        ->where('t.club = :club')
                        ->setParameter('club', $idClub)
                        ->orderBy('t.category', 'DESC');
                },
                'choice_label' => function ($team) {
                    return $team->getClub()->getName() . ' - ' . $team->getCategory() . ' - ' . $team->getLevel();
                },
            ])
                ;

//        $builder->get('roles')
//            ->addModelTransformer(new CallbackTransformer(
//                function ($rolesArray) {
//                    // transform the array to a string
//                    return count($rolesArray) ? $rolesArray[0] : null;
//                },
//                function ($rolesString) {
//                    // transform the string back to an array
//                    return [$rolesString];
//                }
//            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['idClub']);
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
