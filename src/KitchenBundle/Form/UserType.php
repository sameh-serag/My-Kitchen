<?php

namespace KitchenBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Validator\Constraints\NotBlank;


class UserType extends AbstractType
{
    private $type;

    public function __construct($type = 0) {
        $this->type = $type;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if(!$this->type) {
            $builder
                ->add('username', NULL, array(
                    'constraints' => array(new NotBlank())
                ))
                ->add('email', NULL, array(
                    'constraints' => array(new NotBlank())
                ))
                ->add('password', NULL, array(
                    'constraints' => array(new NotBlank())
                ))
                ->add('city', NULL, array(
                    'constraints' => array(new NotBlank())
                ))
                ->add('country', NULL, array(
                    'constraints' => array(new NotBlank())
                ))
                ->add('name', NULL, array(
                    'constraints' => array(new NotBlank())
                ))
                ->add('deliveryNotes', NULL, array(
                    'constraints' => array(new NotBlank())
                ))
                ->add('mobile', NULL, array(
                    'constraints' => array(new NotBlank())
                ))
                ->add('notes')
                ->add('rate')
                ->add('file')
                ->add('inHoliday')
                ->add('type')
                ->add('lat', NULL, array(
                    'constraints' => array(new NotBlank())
                ))
                ->add('lng', NULL, array(
                    'constraints' => array(new NotBlank())
                ));
        }
        else{
        $builder
            ->add('username', NULL, array(
                'constraints' => array(new NotBlank())
            ))
            ->add('email', NULL, array(
                'constraints' => array(new NotBlank())
            ))
            ->add('password', NULL, array(
                'constraints' => array(new NotBlank())
            ))
            ->add('city', NULL, array(
                'constraints' => array(new NotBlank())
            ))
            ->add('country', NULL, array(
                'constraints' => array(new NotBlank())
            ))
            ->add('mobile')
            ->add('rate')
            ->add('inHoliday')
            ->add('type')
            ->add('lat', NULL, array(
                'constraints' => array(new NotBlank())
            ))
            ->add('lng', NULL, array(
                'constraints' => array(new NotBlank())
            ));
    }

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'KitchenBundle\Entity\User',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'kitchenbundle_user';
    }
}
