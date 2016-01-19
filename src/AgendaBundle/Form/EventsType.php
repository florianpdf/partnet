<?php

namespace AgendaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('start', 'datetime', array(
                'label' => 'Date de début',
                'required' => true,
                'hours' => range(8, 20),
                'minutes' => range(0, 30, 30)
            ))
            ->add('end', 'datetime', array(
                'label' => 'Date de fin',
                'required' => true,
                'hours' => range(8, 20),
                'minutes' => range(0, 30, 30)
            ))
            ->add('titre', 'text', array('label' => 'Titre', 'required' => true))
            ->add('resume', 'textarea', array('label' => 'Description', 'required' => false))
            ->add('fil_actu', 'checkbox', array(
                'label' => 'Ajouter au fil d\'actualité',
                'required' => false))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AgendaBundle\Entity\Events'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'agendabundle_events';
    }
}
