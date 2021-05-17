<?php

namespace App\Domain\Form;

use App\Domain\Auth\Users;
use App\Domain\Auth\Roles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $roles)
    {
        $builder
            ->add('nom')
            ->add("roles", ChoiceType::class, [
                'choices' => Users::ROLES,
                'expanded' => true,
                'multiple' => true
            ])
            ->add('password')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
