<?php
// UserBundle/Form/RegistrationType.php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('organisme', 'choice', array('choices' => array(
                'Cap emploi' => 'Cap emploi',
                'DIRECCTE' => 'DIRECCTE',
                'Mission locale' => 'Mission locale',
                'Pôle emploi' => 'Pôle emploi',
                'Sous-préfecture' => 'Sous-préfecture'
                )))
            ->add('telephone', 'text', array('label' => 'Téléphone'))
            ->remove('username')
            ->remove('PlainPassword')
            ->add('current_password', 'password', array(
                'label' => 'Mot de passe actuel *',
                'mapped' => false,
                'constraints' => new UserPassword()
            ))
            ->add('poste', 'text', array('label' => 'Fonction'))
            ->add('email', 'email', array('label' => 'Email'))
            ->add('nom', 'text')
            ->add('prenom', 'text', array('label' => 'Prénom'))
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