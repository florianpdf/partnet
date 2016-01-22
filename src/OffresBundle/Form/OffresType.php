<?php

namespace OffresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OffresType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('entreprise')
            ->add('lieu')
            ->add('resume')
            ->add('fil_actu', 'checkbox')
            ->add('file', 'file', array('label' => 'Company logo', 'required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OffresBundle\Entity\Offres'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'offresbundle_offres';
    }
}
