<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'register.name',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un nom',
                    ]),
                    new Length([
                        'min' => 1,
                        'max' => 150,
                        'maxMessage' => 'Votre nom doit comporter au moins {{limit}} caractères',
                    ]),
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'register.firstname',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un prénom',
                    ]),
                    new Length([
                        'min' => 1,
                        'max' => 150,
                        'maxMessage' => 'Votre prénom doit comporter au moins {{limit}} caractères',
                    ]),
                ]
            ])
            ->add('birthday', DateType::class, [
                'label' => 'register.birthday',
                'years' => range(date('Y')-80, date('Y')-4),
            ])
            ->add('city', TextType::class, [
                'label' => 'register.city',
            ])
            ->add('postCode', TextType::class,[
                'label' => 'register.postcode',  
             ])
            ->add('country', CountryType::class, [
                'preferred_choices' => ['FR'],
                'label' => 'register.country',
  
            ])
            ->add('email', EmailType::class, [
                'label' => 'register.email'
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'register.plainPassword',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{limit}} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
