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
                ->add('status')
                ->add('cancelTime')
                ->add('deliveryDate')
                ->add('deliveryTime')
                ->add('userLat')
                ->add('userLng')
                ->add('total_price')
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
                ->add('status')
                ->add('cancelTime')
                ->add('deliveryDate')
                ->add('deliveryTime')
                ->add('userLat')
                ->add('userLng')
                ->add('total_price')
                ->add('userMobile')
                ->add('notes')
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
                ->add('total_price')
                ->add('userMobile')
                ->add('notes')
        ;
    }
}