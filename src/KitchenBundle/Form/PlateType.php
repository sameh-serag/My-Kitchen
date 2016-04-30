<?php

namespace KitchenBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;

class PlateType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('isHot')
            ->add('file', 'file', array(
                'multiple' => true
            ))
            ->add('description')
            ->add('price')
            ->add('chef', NULL, array(
                'property' => 'number'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'KitchenBundle\Entity\Plate',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'kitchenbundle_plate';
    }
}
