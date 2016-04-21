<?php

namespace KitchenBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;

class RequestType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('deliveryDate', 'date',  array('widget' => "single_text"))
            ->add('deliveryTime', 'time',  array('widget' => "single_text"))
            ->add('userLat')
            ->add('userLng')
            ->add('totalPrice')
            ->add('status')
            ->add('chef', NULL, array(
                'property' => 'number'
            ))
            ->add('user', NULL, array(
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
            'data_class' => 'KitchenBundle\Entity\Request',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'kitchenbundle_request';
    }
}
