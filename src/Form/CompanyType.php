<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('phone')
            ->add('website')
            ->add('address1')
            ->add('address2')
            ->add('state')
            ->add('county')
            ->add('city')
            ->add('zip')
            ->add('tagline')
            ->add('description')
            ->add('specialty1')
            ->add('specialty2')
            ->add('specialty3')
            ->add('logo')
            ->add('ownerImage')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
