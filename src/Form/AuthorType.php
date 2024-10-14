<?php

namespace App\Form;

use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'sanitize_html' => true, // Nettoyer les données recuillies contre les injections SQL et de script JavaScript
                'required' => true,
                'help' => 'Veuillez renseigner votre prénom',
                'label' => 'Prénom'

            ])
            ->add('lastname', TextType::class, [
                'sanitize_html' => true,
                'required' => true,
                'help' => 'Veuillez renseigner votre nom de famille',
                'label' => 'Nom de famille'
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'help' => 'Veuillez renseigner votre email',
                'label' => 'Votre Email'
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identiques.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Repeter le mot de passe'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
