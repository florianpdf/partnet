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
            ->remove('username')
            ->add('organisme', 'choice', array('choices' => array(
                'Pôle emploi' => 'Pôle emploi',
                'Cap emploi' => 'Cap emploi',
                'Mission locale' => 'Mission locale',
                'Sous-préfecture' => 'Sous-préfecture',
                'DIRECCTE' => 'DIRECCTE'
            )))
        ;
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