<?php

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Admin\Admin;
use Doctrine\ORM\EntityRepository;

class RateAdmin extends Admin {

    /**
     * this variable holds the route name prefix for this actions
     * @var string
     */
    protected $baseRouteName = 'rate_admin';

    /**
     * this variable holds the url route prefix for this actions
     * @var string
     */
    protected $baseRoutePattern = 'rate';

    public function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('id')
                ->add('time')
                ->add('hot')
                ->add('clean')
                ->add('taste')
                ->add('value')
                ->add('chef', null, array('admin_code' => 'chef_admin'))
                ->add('user', null, array('admin_code' => 'user_admin'))
                ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    )
                ))
        ;
    }

    public function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('id')
                ->add('time')
                ->add('hot')
                ->add('clean')
                ->add('taste')
                ->add('value')
                ->add('comment')
                ->add('chef', null, array('admin_code' => 'chef_admin'))
                ->add('user', null, array('admin_code' => 'user_admin'))
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('time')
                ->add('hot')
                ->add('clean')
                ->add('taste')
                ->add('value')
                ->add('chef', null, array(),null,array(
                    'class' => 'KitchenBundle:User',
                    'query_builder' => function(EntityRepository $er) {
                        $qb = $er->createQueryBuilder('u');
                        return $qb->where($qb->expr()->eq('u.type', '0'));
                    }
                ))
                ->add('user', null, array(),null,array(
                    'class' => 'KitchenBundle:User',
                    'query_builder' => function(EntityRepository $er) {
                        $qb = $er->createQueryBuilder('u');
                        return $qb->where($qb->expr()->eq('u.type', '1'));
                    }
                ))
        ;
    }

    public function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('time', 'choice', array('choices' => array('1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5')))
                ->add('hot', 'choice', array('choices' => array('1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5')))
                ->add('clean', 'choice', array('choices' => array('1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5')))
                ->add('taste', 'choice', array('choices' => array('1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5')))
                ->add('value', 'choice', array('choices' => array('1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5')))
                ->add('comment')
                ->add('chef', 'entity', array(
                    'required' => false,
                    'class' => 'KitchenBundle:User',
                    'query_builder' => function(EntityRepository $er) {
                        $qb = $er->createQueryBuilder('u');
                        return $qb->where($qb->expr()->eq('u.type', '0'));
                    }
                ),array('admin_code' => 'chef_admin'))
                ->add('user', 'entity', array(
                    'required' => false,
                    'class' => 'KitchenBundle:User',
                    'query_builder' => function(EntityRepository $er) {
                        $qb = $er->createQueryBuilder('u');
                        return $qb->where($qb->expr()->eq('u.type', '1'));
                    }
                ),array('admin_code' => 'user_admin'))
        ;
    }

}
