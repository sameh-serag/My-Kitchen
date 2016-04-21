<?php

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Admin\Admin;

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
                ->add('status', null, array('template' => 'AdminBundle:General:list_status.html.twig'))
                ->add('cancelTime')
                ->add('deliveryDate')
                ->add('deliveryTime')
                ->add('userLat')
                ->add('userLng')
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
                ->add('status', null, array('template' => 'AdminBundle:General:show_status.html.twig'))
                ->add('cancelTime')
                ->add('deliveryDate')
                ->add('deliveryTime')
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
                ->add('createdAt')
        ;
    }

    public function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('status', 'choice', array('choices' => array('0' => 'Pendding', '1' => 'Approved', '2' => 'Rejected')))
                ->add('cancelTime', null, array('attr' => array('data-class' => 'datetime'), 'widget' => 'single_text', 'format' => 'yyyy-MM-dd H:mm'))
                ->add('deliveryDate', null, array('attr' => array('data-class' => 'date'), 'widget' => 'single_text', 'format' => 'yyyy-MM-dd'))
                ->add('deliveryTime')
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
