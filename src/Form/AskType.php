<?php

namespace App\Form;

use App\Entity\Ask;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                "label_attr" => ["class" => "text-2xl"]
            ])
            ->add('author', TextType::class, [
                'label' => 'Auteur',
                "label_attr" => ["class" => "text-2xl"]
            ])
            ->add('editor', TextType::class, [
                'label' => "Maison d'édition",
                "label_attr" => ["class" => "text-2xl"]
            ])
            ->add('Envoyer', SubmitType::class, [
                'attr' => ["class" => "text-2xl p-1 bg-sky-600 rounded hover:bg-sky-700 text-white mx-auto my-5 block"],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ask::class,
        ]);
    }
}
