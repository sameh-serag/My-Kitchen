<?php

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Admin\Admin;

class UserAdmin extends Admin {

    /**
     * this variable holds the route name prefix for this actions
     * @var string
     */
    protected $baseRouteName = 'user_admin';

    /**
     * this variable holds the url route prefix for this actions
     * @var string
     */
    protected $baseRoutePattern = 'user';

    public function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('id')
                ->add('name')
                ->add('username')
                ->add('city')
                ->add('mobile')
                ->add('rate')
                ->add('inHoliday')
                ->add('email')
                ->add('image', null, array('template' => 'AdminBundle:General:list_image.html.twig'))
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
                ->add('username')
                ->add('city')
                ->add('mobile')
                ->add('rate')
                ->add('inHoliday')
                ->add('email')
                ->add('lat')
                ->add('lng')
                ->add('notes')
                ->add('deliveryNotes')
                ->add('type')
                ->add('status')
                ->add('image', null, array('template' => 'AdminBundle:General:show_image.html.twig'))
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('name')
                ->add('username')
                ->add('city')
                ->add('mobile')
                ->add('rate')
                ->add('inHoliday')
                ->add('email')
        ;
    }

    public function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('name')
                ->add('username')
                ->add('userPassword', 'password', array('label' => 'Password', 'required' => false))
                ->add('city')
                ->add('mobile')
                ->add('rate')
                ->add('inHoliday', null, array('required' => false))
                ->add('email')
                ->add('lat')
                ->add('lng')
                ->add('notes')
                ->add('deliveryNotes')
                ->add('type', 'choice', array('choices' => array('0' => 'Chef', '1' => 'User')))
                ->add('status', 'choice', array('choices' => array('0' => 'Pendding', '1' => 'Approved', '2' => 'Rejected')))
                ->add('file', 'file', array('required' => false, 'label' => 'Image'))
        ;
    }

}
