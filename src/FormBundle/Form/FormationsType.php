<?php

namespace FormBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormationsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('titre')
            ->add('nbPlace')
            ->add('lieu')
            ->add('resume')
            ->add('file', 'file', array('required' => false, 'label' => 'Fichier associé', 'attr' => array('accept' => 'application/pdf, application/xpdf')))
            ->add('file2', 'file', array('required' => false, 'label' => 'Fichier associé n°2', 'attr' => array('accept' => 'application/pdf, application/xpdf')))
            ->add('fil_actu', 'checkbox', array(
                'label' => 'Ajouter au fil d\'actualité',
                'required' => false,
            ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FormBundle\Entity\Formations'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'formbundle_formations';
    }
}
