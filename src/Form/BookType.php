<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $id = $options['id'];
        $builder
            ->add('title', TextType::class, [
                'label' => 'book.title',
            ])
            ->add('author', TextType::class, [
                'label' => 'book.author'
            ])
            ->add('resume', TextareaType::class, [
                'label' => 'book.resume',
                'required' => false,
            ])
            ->add('picture', UrlType::class, [
                'label' => 'book.picture'
            ])
            ->add('price', MoneyType::class, [
                'label' => 'book.price',
                'required' => false,
            ])
            ->add('isRead', CheckboxType::class, [
                'label' => 'book.isRead',
                'required' => false,
                ]) 
            ->add('own', CheckboxType::class, [
                'label' => 'book.own',
                'required' => false,
            ])
            ->add('category', EntityType::class, [
                'label' => 'book.category',
                'class' => Category::class,
                'query_builder' => function(CategoryRepository $repository) use($id) {
                    return $repository->createQueryBuilder('c')
                    ->join('c.library', 'l')
                    ->where('l.id = :id')
                    ->setParameter('id', $id);
                },
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ],)
            ->add('submit', SubmitType::class, [
                'label' => 'book.valid'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            $resolver->setRequired('id')
        ]);
    }
}
