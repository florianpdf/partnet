<?php
// src/GedBundle/Form/Type/DocumentType.php

namespace GedBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', 'text')
            ->add('resume', 'textarea', array('label' => 'Résumé'))
            ->add('auteur', 'text')
            ->add('dureeDeVie', 'date', array('label' => 'Fin de vie'))
            ->add('url', 'file', array('label' => 'Fichier'))
            ->add('save', 'submit', array('label' => 'Envoyer'))
        ;
    }

    public function getName()
    {
        return 'document';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GedBundle\Entity\Documents',
        ));
    }
}
