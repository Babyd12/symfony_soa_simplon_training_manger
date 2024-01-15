<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\Role;
use App\Entity\User;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('full_name', TextType::class, [
                'label' => 'Full Name',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('level_of_study', TextType::class, [
                'label' => 'Level of study',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
           
            ->add('formation', EntityType::class, [
                'class' => Formation::class,
                'choice_label' => 'formation',
                'label' => 'formation',
                'attr'=> [
                    'class' => 'form_control',
                ]
            ])
            ->add('role', EntityType::class, [
                'class' => Role::class,
                'choice_label' => 'role',
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'attr' => [
                    'class' => 'form-control',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}