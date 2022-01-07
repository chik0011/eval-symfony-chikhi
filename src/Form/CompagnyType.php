<?php

namespace App\Form;

use App\Entity\Compagny;
use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CompagnyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('siret')
            ->add('address')
            ->add('zipCode')
            ->add('city')
            ->add('client', EntityType::class, [
                'class' => Customer::class,
                'choice_label' => 'firstname',
                'multiple' => true,
                'label' => 'Client'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Compagny::class,
        ]);
    }
}
