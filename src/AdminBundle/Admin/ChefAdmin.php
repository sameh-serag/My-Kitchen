<?php

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Admin\Admin;

class ChefAdmin extends Admin {

    /**
     * this variable holds the route name prefix for this actions
     * @var string
     */
    protected $baseRouteName = 'chef_admin';

    /**
     * this variable holds the url route prefix for this actions
     * @var string
     */
    protected $baseRoutePattern = 'chef';

    public function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('id')
                ->add('name')
                ->add('username')
                ->add('country')
                ->add('city')
                ->add('mobile')
                ->add('rate')
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
                ->add('country')
                ->add('city')
                ->add('mobile')
                ->add('rate')
                ->add('inHoliday')
                ->add('email')
                ->add('Location', null, array('template' => 'AdminBundle:General:show_chef_location.html.twig'))
                ->add('lat')
                ->add('lng')
                ->add('notes')
                ->add('deliveryNotes')
                ->add('status', null, array('template' => 'AdminBundle:General:show_status.html.twig'))
                ->add('image', null, array('template' => 'AdminBundle:General:show_image.html.twig'))
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('name')
                ->add('username')
                ->add('country')
                ->add('city')
                ->add('mobile')
                ->add('rate')
                ->add('inHoliday')
                ->add('email')
        ;
    }

    public function configureFormFields(FormMapper $formMapper) {
        $class = 'new';

        if ($this->getSubject() && $this->getSubject()->getId()) {
            $class = 'edit';
        }

        $formMapper
                ->add('name')
                ->add('username')
                ->add('userPassword', 'password', array('label' => 'Password', 'required' => false))
                ->add('country', null, array('attr' => array('class' => 'countries-list ' . $class)))
                ->add('city', null, array('attr' => array('class' => 'cities-list')))
                ->add('mobile')
                ->add('rate')
                ->add('inHoliday', null, array('required' => false))
                ->add('email')
                ->add('lat', null, array('attr' => array('class' => 'LatField')))
                ->add('lng', null, array('attr' => array('class' => 'LngField')))
                ->add('notes')
                ->add('deliveryNotes')
                ->add('status', 'choice', array('choices' => array('0' => 'معلق', '1' => 'موافق عليه', '2' => 'مرفوض')))
                ->add('file', 'file', array('required' => false, 'label' => 'Image'))
                ->setHelps(array(
                    'userPassword' => 'Password required in new chef create.'
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
        $u->setType('0');
    }

    public function createQuery($context = 'list') {
        $query = parent::createQuery($context);
        $query->andWhere(
                $query->expr()->eq($query->getRootAliases()[0] . '.type', ':cheftype')
        );
        $query->setParameter('cheftype', '0');
        return $query;
    }

}
