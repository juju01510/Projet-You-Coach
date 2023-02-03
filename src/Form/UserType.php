<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => "Prénom",
            ])
            ->add('lastname', TextType::class, [
                'label' => "Nom",
            ])
            ->add('email')
            ->add('phone', TextType::class, [
                'label' => "Téléphone"
            ])
//            ->add('roles')
//            ->add('password')
//            ->add('isVerified')
//            ->add('club')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
