<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Admin controller.
 */
class AdminController extends Controller {    

    public function loginAction() {
        $request = $this->getRequest();
        $session = $request->getSession();
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                    SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        return $this->render('AdminBundle:General:login.html.twig', array(
                    'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                    'error' => $error
        ));
    }

    public function getCountryCitiesAction(Request $request) {
        $id = $request->get('countryid');
        $em = $this->getDoctrine()->getManager();
        $country = $em->getRepository('KitchenBundle:Country')->find($id);
        if ($country) {
            $cities = $em->getRepository('KitchenBundle:City')->findBy(array('country' => $country));
            if($cities) {
                $citiesArr = array();
                foreach ($cities as $city) {
                    $cities = array();

                    $cities['id'] = $city->getId();
                    $cities['name'] = $city->getName();
                    $citiesArr[] = $cities;
                }

                return new JsonResponse($citiesArr);
            } else {
                return new JsonResponse('failed');
            }
        } else {
            return new JsonResponse('failed');
        }
    }
}
