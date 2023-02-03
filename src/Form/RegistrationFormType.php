<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
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

                'first_options'  => [
//                    'label' => 'Mot de passe',
//                    'hash_property_path' => 'password',
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
//                        new Regex([
//                            'message' => 'Votre mot de passe doit comprendre au moins 6 caractères, une majuscule, une minuscule, un chiffre et un caractère spéciale',
//                            'pattern' => '/^(?=.[0-9])(?=.[a-z])(?=.[A-Z])(?=.\W)(?!.* ).{6,}$/',
//                        ])
                    ],
                ],

                'second_options' => [
                    'label' => 'Confirmez votre mot de passe',
                    'attr' => ['placeholder' => 'Confirmez votre mot de passe'],
                ],

                'mapped' => false,
            ]);
//            ->add('plainPassword', RepeatedType::class, [
//                'type' => PasswordType::class,
//                'invalid_message' => 'Les mots de passe doivent correspondre',
//                'options' => ['attr' => ['class' => 'password-field']],
//                'required' => true,
//                'first_options'  => ['label' => 'Mot de passe'],
//                'second_options' => ['label' => 'Confirmez votre mot de passe'],
//            ]);
//            ->add('plainPassword', PasswordType::class, [
//                // instead of being set onto the object directly,
//                // this is read and encoded in the controller
//                'mapped' => false,
//                'attr' => ['autocomplete' => 'new-password'],
//                'constraints' => [
//                    new NotBlank([
//                        'message' => 'Please enter a password',
//                    ]),
//                    new Length([
//                        'min' => 6,
//                        'minMessage' => 'Your password should be at least {{ limit }} characters',
//                        // max length allowed by Symfony for security reasons
//                        'max' => 4096,
//                    ]),
//                ],
//            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
