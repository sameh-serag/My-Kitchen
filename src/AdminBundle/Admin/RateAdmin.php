<?php

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Admin\Admin;

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
                ->add('chef')
                ->add('user')
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
                ->add('chef')
                ->add('user')
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
                ->add('comment')
                ->add('chef')
                ->add('user')
        ;
    }

    public function configureFormFields(FormMapper $formMapper) {        
        $formMapper
                ->add('time')
                ->add('hot')
                ->add('clean')
                ->add('taste')
                ->add('value')
                ->add('comment')
                ->add('chef')
                ->add('user')
        ;
    }
}