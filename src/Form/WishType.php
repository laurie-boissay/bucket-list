<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Wish;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => ['placeholder' => 'Votre idée']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => ['placeholder' => 'Sa description']
            ])
            ->add('author', TextType::class, [
                'label' => 'Votre pseudo',
                'required' => false,
                'attr' => ['placeholder' => 'Anonyme'],
                'empty_data' => 'Anonyme', // Valeur par défaut si le champ est vide
            ])

            ->add('category', EntityType::class, [
                'label' => 'Category',
                // quelle est la classe à afficher ici ?
                'class' => Category::class,
                // quelle propriété utiliser pour les <option> dans la liste déroulante ?
                'choice_label' => 'name',
                'placeholder' => '--Choose a category--'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
        ]);
    }
}
