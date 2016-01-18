<?php
// UserBundle/Form/RegistrationType.php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', array('label' => 'Email'))
            ->add('organisme', 'choice', array('choices' => array(
                'Cap emploi' => 'Cap emploi',
                'DIRECCTE' => 'DIRECCTE',
                'Mission locale' => 'Mission locale',
                'Pôle emploi' => 'Pôle emploi',
                'Sous-préfecture' => 'Sous-préfecture'
                )))
            ->add('telephone', 'text', array('label' => 'Téléphone'))

            ->add('poste', 'text', array('label' => 'Fonction'))

            ->add('nom', 'text', array('label' => 'Nom'))
            ->add('prenom', 'text', array('label' => 'Prénom'))
            ->remove('current_password')
            ->remove('username');
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