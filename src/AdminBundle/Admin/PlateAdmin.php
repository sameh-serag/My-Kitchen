<?php

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Admin\Admin;
use Doctrine\ORM\EntityRepository;

class PlateAdmin extends Admin {

    /**
     * this variable holds the route name prefix for this actions
     * @var string
     */
    protected $baseRouteName = 'plate_admin';

    /**
     * this variable holds the url route prefix for this actions
     * @var string
     */
    protected $baseRoutePattern = 'plate';

    public function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('id')
                ->add('name')
                ->add('price')
                ->add('isHot')
                ->add('description')
                ->add('image', null, array('template' => 'AdminBundle:General:list_image.html.twig'))
                ->add('chef', null, array('admin_code' => 'chef_admin'))
                ->add('category')
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
                ->add('name')
                ->add('price')
                ->add('isHot')
                ->add('description')
                ->add('image', null, array('template' => 'AdminBundle:General:show_image.html.twig'))
                ->add('chef', null, array('admin_code' => 'chef_admin'))
                ->add('category')
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('name')
                ->add('price')
                ->add('isHot')
                ->add('chef', null, array(),null,array(
                    'class' => 'KitchenBundle:User',
                    'query_builder' => function(EntityRepository $er) {
                        $qb = $er->createQueryBuilder('u');
                        return $qb->where($qb->expr()->eq('u.type', '0'));
                    }
                ))
                ->add('category')
        ;
    }

    public function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('name')
                ->add('price')
                ->add('isHot', null, array('required' => false))
                ->add('description')
                ->add('file', 'file', array('required' => true, 'label' => 'Image'))
                ->add('chef', 'entity', array(
                    'required' => false,
                    'class' => 'KitchenBundle:User',
                    'query_builder' => function(EntityRepository $er) {
                        $qb = $er->createQueryBuilder('u');
                        return $qb->where($qb->expr()->eq('u.type', '0'));
                    }
                ), array('admin_code' => 'chef_admin'))
                ->add('category')
        ;
    }

}
