<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Technology;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label' => 'Titre du projet'
            ])
            ->add('description', null, [
                'label' => 'Description du projet'
            ])
            ->add('screenshot', null, [
                'label' => 'Screenshot',
                'required' => false,
            ])
            ->add('file', FileType::class, [
                'label' => 'Télécharger un screenshot (max. 2Mo)', // Label affiché
                'required' => false, // Le fichier peut être facultatif
                'mapped' => false, // Indique que ce champ ne correspond pas directement à une propriété de l'entité
            ])
            ->add('created_at', null, [
                'widget' => 'single_text',
                'label' => 'Date de création'
            ])
            ->add('github_url', null, [
                'label' => 'URL GitHub'
            ])
            ->add('url', null, [
                'label' => 'URL du projet'
            ])
            ->add('technologies', EntityType::class, [
                'class' => Technology::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Liste des technologies'
            ])
        ;


        if ($options['is_admin']) {
            $builder->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
            ]);
        } else {
            $builder->add('user', HiddenType::class, [
                'data' => $options['current_user']->getId(),
                'mapped' => false,
            ]);

            $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($options) {
                $form = $event->getForm();
                $project = $event->getData();


                $project->setUser($options['current_user']);
            });
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
            'is_admin' => false,            // Indique si l'utilisateur est admin
            'current_user' => null,         // L'utilisateur connecté
        ]);

        $resolver->setAllowedTypes('is_admin', 'bool');
        $resolver->setAllowedTypes('current_user', ['null', User::class]);
    }
}
