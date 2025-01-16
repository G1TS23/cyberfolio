<?php

namespace App\Form;

use App\Entity\Profile;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('phone_number', null, [
                'label' => 'Numéro de téléphone'
            ])
            ->add('headline', null, [
                'label' => 'Sous-titre'
            ])
            ->add('biography', null, [
                'label' => 'Biographie'
            ])
            ->add('address', null, [
                'label' => 'Adresse'
            ])
            ->add('zipcode', null, [
                'label' => 'Code postal'
            ])
            ->add('city', null, [
                'label' => 'Ville'
            ])
            ->add('country', null, [
                'label' => 'Pays'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
