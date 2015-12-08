<?php

namespace GedBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', 'text')
            ->add('resume', 'textarea', array('label' => 'Résumé', 'required' => false))
            ->add('auteur', 'text', array('required' => false))
            ->add('finDeVie', 'date', array('label' => 'Fin de validité', 'required' => false))
            ->add('file', 'file', array('label' => 'Document', 'attr' => array('accept' => 'application/pdf, application/xpdf')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GedBundle\Entity\Documents'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gedbundle_documents';
    }
}
