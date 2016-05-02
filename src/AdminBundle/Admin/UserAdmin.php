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
                ->add('mobile')
                ->add('email')                
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
                ->add('mobile')
                ->add('email')
                ->add('Location', null, array('template' => 'AdminBundle:General:show_chef_location.html.twig'))
                ->add('lat')
                ->add('lng')                
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('name')
                ->add('username')
                ->add('mobile')
                ->add('email')
        ;
    }

    public function configureFormFields(FormMapper $formMapper) {        
        $formMapper
                ->add('name')
                ->add('username')
                ->add('userPassword', 'password', array('label' => 'Password', 'required' => false))
                ->add('mobile')
                ->add('email')
                ->add('lat', null, array('attr' => array('class' => 'LatField')))
                ->add('lng', null, array('attr' => array('class' => 'LngField')))                             
                ->setHelps(array(
                    'userPassword' => 'Password required in new user create.'
                ))
        ;
    }

    public function prePersist($object) {
        parent::prePersist($object);
        $this->updateUser($object);
    }

    public function preUpdate($object) {
        parent::preUpdate($object);
        $this->updateUser($object);
    }

    public function updateUser(\KitchenBundle\Entity\User $u) {
        if ($u->getUserPassword()) {
            $u->setPassword(md5($u->getUserPassword()));
        }
        $u->setType('1');
    }

    public function createQuery($context = 'list') {
        $query = parent::createQuery($context);
        $query->andWhere(
                $query->expr()->eq($query->getRootAliases()[0] . '.type', ':usertype')
        );
        $query->setParameter('usertype', '1');
        return $query;
    }
}
