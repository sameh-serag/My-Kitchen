<?php

namespace KitchenBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;

class RatingType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('time', NULL, array(
                'constraints' => array( new NotBlank(), new Choice(array(0, 1, 2, 3, 4, 5)))
            ))
            ->add('clean', NULL, array(
                'constraints' => array( new NotBlank(), new Choice(array(0, 1, 2, 3, 4, 5)))
            ))
            ->add('hot', NULL, array(
                'constraints' => array( new NotBlank(), new Choice(array(0, 1, 2, 3, 4, 5)))
            ))
            ->add('value', NULL, array(
                'constraints' => array( new NotBlank(), new Choice(array(0, 1, 2, 3, 4, 5)))
            ))
            ->add('taste', NULL, array(
                'constraints' => array( new NotBlank(), new Choice(array(0, 1, 2, 3, 4, 5)))
            ))
            ->add('comment')
            ->add('user', NULL, array(
                'property' => 'number'
            ))
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
            'data_class' => 'KitchenBundle\Entity\Rating',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'kitchenbundle_rating';
    }
}
