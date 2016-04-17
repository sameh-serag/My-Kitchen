<?php

namespace KitchenBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('KitchenBundle:Default:index.html.twig', array('name' => $name));
    }
}
