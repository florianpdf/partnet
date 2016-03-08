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
            ->add('id_organisme', 'entity', array(
                'class'    => 'AppBundle:Organisme',
                'property' => 'id',
                'choice_label' => 'nom',
                'label' => 'Organisme',
                'multiple' => false,
                'required' => false,
                'placeholder' => 'Extérieur'
            ))
            ->add('telephone', 'text', array('label' => 'Téléphone', 'required' => false))

            ->add('poste', 'text', array('label' => 'Fonction', 'required' => false))

            ->add('nom', 'text', array('label' => 'Nom', 'required' => false))
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