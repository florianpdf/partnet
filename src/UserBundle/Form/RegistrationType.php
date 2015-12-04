<?php
// UserBundle/Form/RegistrationType.php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('organisme', 'choice', array('choices' => array(
                'Pole emploi' => 'Pole emploi',
                'CAP Emploi' => 'CAP Emploi',
                'Mission Local' => 'Mission Local'
                )))
            ->add('roles', 'collection', array(
                'type'   => 'choice',
                'options'  => array(
                    'label' => false,
                    'choices'  => array(
                        'ROLE_ADMIN' => 'ROLE_ADMIN',
                        'ROLE_USER'     => 'ROLE_USER',
                    ),
                ),
            ));
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'app_user_registration';
    }
}