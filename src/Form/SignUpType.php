<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignUpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                "label_attr" => ["class" => "text-2xl"]
            ])
            ->add('password', RepeatedType::class, [
                "type" => PasswordType::class,
                "invalid_message" => "Les mots de passes ne correspondent pas",
                "options" => ["attr" => ["class" => "password-field"]],
                "required" => true,
                "first_options" => ["label" => "Mot de passe", "label_attr" => ["class" => "text-2xl"]],
                "second_options" => ["label" => "Confirmer le mot de passe", "label_attr" => ["class" => "text-2xl"]],
                "label_attr" => ["class" => "text-2xl"]
            ])
            ->add('Confirmer', SubmitType::class, [
                "attr" => ["class" => "text-2xl p-1 bg-sky-600 rounded hover:bg-sky-700 text-white mx-auto my-5 block"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
