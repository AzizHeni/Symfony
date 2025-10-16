<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormView;

class BookType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')  // Titre du livre
            
            ->add('publicationDate')  // Date de publication
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'Science-Fiction' => 'Science-Fiction',
                    'Mystery' => 'Mystery',
                    'Autobiography' => 'Autobiography',
                ],
                'placeholder' => 'Choisir une catégorie',
            ])
            ->add('author', EntityType::class, [
    'class' => Author::class,
    'choice_label' => 'username',  // use existing getter getUsername()
])

        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
