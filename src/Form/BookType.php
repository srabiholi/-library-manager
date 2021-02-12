<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('author', TextType::class, [
                'label' => 'Auteur'
            ])
            ->add('resume', TextareaType::class, [
                'label' => 'Résumé du livre',
                'required' => false,
                // 'attr' => ['class' => 'mb-3'],
            ])
            ->add('picture', UrlType::class, [
                'label' => 'Image ou Première de couverture'
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix',
                'required' => false,
            ])
            ->add('isRead', CheckboxType::class, [
                'label' => 'Livre lu',
                'required' => false,
                ]) 
            ->add('own', CheckboxType::class, [
                'label' => 'Livre en bibliothèque',
                'required' => false,
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégories',
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ],)
            // ->add('library')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
