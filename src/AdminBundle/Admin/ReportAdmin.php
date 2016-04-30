<?php

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Admin\Admin;
use Doctrine\ORM\EntityRepository;

class ReportAdmin extends Admin {

    /**
     * this variable holds the route name prefix for this actions
     * @var string
     */
    protected $baseRouteName = 'report_admin';

    /**
     * this variable holds the url route prefix for this actions
     * @var string
     */
    protected $baseRoutePattern = 'report';

    public function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('id')
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
                ->add('content')
                ->add('user', null, array('admin_code' => 'user_admin'))
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
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
                ->add('user', 'entity', array(
                    'required' => false,
                    'class' => 'KitchenBundle:User',
                    'query_builder' => function(EntityRepository $er) {
                        $qb = $er->createQueryBuilder('u');
                        return $qb->where($qb->expr()->eq('u.type', '1'));
                    }
                ),array('admin_code' => 'user_admin'))
                ->add('content')                
        ;
    }
}