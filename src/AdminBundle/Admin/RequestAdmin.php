<?php

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Admin\Admin;
use Doctrine\ORM\EntityRepository;

class RequestAdmin extends Admin {

    /**
     * this variable holds the route name prefix for this actions
     * @var string
     */
    protected $baseRouteName = 'request_admin';

    /**
     * this variable holds the url route prefix for this actions
     * @var string
     */
    protected $baseRoutePattern = 'request';

    public function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('id')
                ->add('chef', null, array('admin_code' => 'chef_admin'))
                ->add('user', null, array('admin_code' => 'user_admin'))
                ->add('status', null, array('template' => 'AdminBundle:General:list_status.html.twig'))
                ->add('cancelTime')
                ->add('deliveryDate')
                ->add('deliveryTime')
                ->add('totalPrice')
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
                ->add('chef', null, array('admin_code' => 'chef_admin'))
                ->add('user', null, array('admin_code' => 'user_admin'))
                ->add('status', null, array('template' => 'AdminBundle:General:show_status.html.twig'))
                ->add('cancelTime')
                ->add('deliveryDate')
                ->add('deliveryTime')
                ->add('Location', null, array('template' => 'AdminBundle:General:show_location.html.twig'))
                ->add('userLat')
                ->add('userLng')
                ->add('totalPrice')
                ->add('userMobile')
                ->add('notes')
                ->add('requestdetails', null, array('template' => 'AdminBundle:General:show_request_details.html.twig'))
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
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
                ->add('createdAt', 'doctrine_orm_date', array(), null, array('widget' => 'single_text', 'required' => false,  'attr' => array('class' => 'datepicker', 'data-class' => 'date')))                
                ->add('userMobile')
                ->add('status', 'doctrine_orm_choice', array(), 'choice', array('choices' => array('0' => 'Pendding', '1' => 'Approved', '2' => 'Rejected')))
        ;
    }

    public function configureFormFields(FormMapper $formMapper) {
        $formMapper
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
                ->add('status', 'choice', array('choices' => array('0' => 'معلق', '1' => 'موافق عليه', '2' => 'مرفوض')))
                ->add('cancelTime', null, array('attr' => array('data-class' => 'datetime'), 'widget' => 'single_text', 'format' => 'yyyy-MM-dd H:mm'))
                ->add('deliveryDate', null, array('attr' => array('data-class' => 'date'), 'widget' => 'single_text', 'format' => 'yyyy-MM-dd'))
                ->add('deliveryTime', null, array('attr' => array('data-class' => 'time'), 'widget' => 'single_text'))
                ->add('userLat', null, array('attr' => array('class' => 'LatField')))
                ->add('userLng', null, array('attr' => array('class' => 'LngField')))
                ->add('totalPrice')
                ->add('deliveryPrice')
                ->add('userMobile')
                ->add('notes')
                ->add('requestdetails', 'sonata_type_collection', array(
                    'by_reference' => false,
                    'cascade_validation' => true,
                        ), array(
                    'edit' => 'inline',
                    'inline' => 'table'
                ))
        ;
    }

    public function prePersist($object) {

        foreach ($object->getRequestDetails() as $detail) {

            $detail->setRequest($object);
        }
    }

    public function preUpdate($object) {

        foreach ($object->getRequestDetails() as $detail) {

            $detail->setRequest($object);
        }
    }

}
