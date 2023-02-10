<?php

namespace App\Form;

use App\Entity\Club;
use App\Entity\Team;
use App\Entity\User;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\HttpFoundation\Type\FormTypeHttpFoundationExtension;
use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;
use Symfony\Component\Form\Extension\Validator\Type\UploadValidatorExtension;
use Symfony\Component\Form\Extension\Csrf\Type\FormTypeCsrfExtension;
use Symfony\Component\Validator\Constraints\Regex;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
            ->add('email')
            ->add('phone', TextType::class, [
                'attr' => [
                    'placeholder' => 'Téléphone'
                ],
            ])
//            ->add('roles', ChoiceType::class, [
//                'required' => true,
//                'multiple' => false,
//                'expanded' => false,
//                'choices' => [
//                    'Manager' => 'ROLE_MANAGER',
//                    'Coach' => 'ROLE_COACH',
//                    'Joueur' => 'ROLE_PLAYER',
//                ],
//                'choice_attr' => [
//                    'Joueur' => ['class' => 'roles'],
//                    'Coach' => ['class' => 'roles'],
//                    'Manager' => ['class' => 'roles']
//                ]
//            ])
//            ->add('team', EntityType::class, [
//                'required' => true,
//                'label' => 'Choisir un type',
//                'class' => Team::class,
//                'query_builder' => function (EntityRepository $er) use ($idClub) {
//                    return $er->createQueryBuilder('t')
//                        ->where('t.club = :club')
//                        ->setParameter('club', $idClub)
//                        ->orderBy('t.category', 'DESC');
//                },
//                'choice_label' => function ($team) {
//                    return $team->getClub()->getName() . ' - ' . $team->getCategory() . ' - ' . $team->getLevel();
//                },
//            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions générales',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'label' => 'Password',
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre',
                'required' => true,

                'first_options' => [
                    'attr' => [
                        'placeholder' => 'Mot de passe'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Entrez votre mot de passe',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit comprendre au moins {{ limit }} caractères',
                            'max' => 50,
                        ]),
                    ],
                ],

                'second_options' => [
                    'label' => 'Confirmez votre mot de passe',
                    'attr' => ['placeholder' => 'Confirmez votre mot de passe'],
                ],

                'mapped' => false,
            ]);

        // Data transformer
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
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
