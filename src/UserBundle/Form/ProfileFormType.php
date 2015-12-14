<?php
// UserBundle/Form/RegistrationType.php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('organisme', 'choice', array('choices' => array(
                'Pole emploi' => 'Pole emploi',
                'CAP Emploi' => 'CAP Emploi',
                'Mission Local' => 'Mission Local'
                )))
            ->add('telephone', 'text')
            ->add('poste', 'text')
            ->add('nom', 'text')
            ->add('prenom', 'text')
            ->add('file', 'file', array('label' => 'Photo de profil',
                'required' => false,
                'attr' => array('accept' => 'image/*')));
    }

    public function getParent()
    {
        return 'fos_user_profile';
    }

    public function getName()
    {
        return 'app_user_profile';
    }
}