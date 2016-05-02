<?php

namespace KitchenBundle\Controller;

use KitchenBundle\Entity\Gallery;
use KitchenBundle\Entity\Rating;
use KitchenBundle\Entity\Report;
use KitchenBundle\Entity\RequestDetails;
use KitchenBundle\Entity\User;
use KitchenBundle\Entity\Plate;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;

use KitchenBundle\Form\RatingType;
use KitchenBundle\Form\UserType;
use KitchenBundle\Form\PlateType;
use KitchenBundle\Form\RequestType;
use KitchenBundle\Form\ReportType;

use KitchenBundle\Utils\APIResponse;
use KitchenBundle\Utils\APIError;
use Symfony\Component\Validator\Constraints\DateTime;


class ApiController extends FOSRestController
{

    /**
     * Get All Countries
     *
     * @ApiDoc(
     *   description = "Get All Countries in the System",
     *   output = {
     *    "class" = "KitchenBundle\Entity\Country",
     *     "groups" = {"country"},
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     *
     * @return type
     */
    public function getCountriesAction() {

        $em = $this->getDoctrine()->getManager();

        $countries = $em->getRepository('KitchenBundle:Country')->findAll();

        $apiResponse = new APIResponse();

        if($countries) {
            $apiResponse->setStatus(TRUE);
            $apiResponse->setData($countries);
            // prepare response object with http status 200
            $view = $this->view($apiResponse, Codes::HTTP_OK);
        }
        else {
            $apiResponse->setStatus(FALSE);
            $apiResponse->setError('No countries are found');
            // prepare response object with http status 404 NOT FOUND
            $view = $this->view($apiResponse, Codes::HTTP_NOT_FOUND);
        }

        $context = SerializationContext::create()->setGroups(array("apiResponse", "country"));
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }

    /**
     * Get Cities for the given country
     *
     * @ApiDoc(
     *   description = "Get Cities for the given country",
     *   output = {
     *     "class" = "KitchenBundle\Entity\City",
     *     "groups" = {"cities"},
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when no country found"
     *   }
     * )
     *
     * @param string     $id      country Id
     * @return type
     */
    public function getCitiesAction($id) {

        $em = $this->getDoctrine()->getManager();

        $country = $em->getRepository('KitchenBundle:Country')->findOneBy(array('id'=>$id));

        $apiResponse = new APIResponse();

        if($country) {
            $apiResponse->setStatus(TRUE);
            $apiResponse->setData($country->getCities());
            // prepare response object with http status 200
            $view = $this->view($apiResponse, Codes::HTTP_OK);
        }
        else {
            $apiResponse->setStatus(FALSE);
            $apiResponse->setError('No country found for the given id');
            // prepare response object with http status 404 NOT FOUND
            $view = $this->view($apiResponse, Codes::HTTP_NOT_FOUND);
        }

        $context = SerializationContext::create()->setGroups(array("apiResponse", "cities"));
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }

    /**
     * Get All plates for certain Chef
     *
     * @ApiDoc(
     *   description = "Get All plates for certain Chef",
     *   output = {
     *     "class" = "KitchenBundle\Entity\User",
     *     "groups" = {"chefplates"},
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when no country found"
     *   }
     * )
     *
     * @param string     $chef_id      chef Id
     * @return type
     */
    public function getChefPlatesAction( $chef_id ) {

        $em = $this->getDoctrine()->getManager();
        $apiResponse = new APIResponse();

        if($chef_id){
            $chef = $em->getRepository('KitchenBundle:User')->findOneBy(array('id'=>$chef_id));

            if($chef) {
                $apiResponse->setStatus(TRUE);
                $apiResponse->setData($chef);
                // prepare response object with http status 200
                $view = $this->view($apiResponse, Codes::HTTP_OK);
            }
            else {
                $apiResponse->setStatus(FALSE);
                $apiResponse->setError('No chef found for the given id');
                // prepare response object with http status 404 NOT FOUND
                $view = $this->view($apiResponse, Codes::HTTP_NOT_FOUND);
            }
        }

        $context = SerializationContext::create()->setGroups(array("apiResponse", "chefplates"));
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }

    /**
     * Get All comments for certain Chef
     *
     * @ApiDoc(
     *   description = "Get All comments for certain Chef",
     *   output = {
     *     "class" = "KitchenBundle\Entity\Rating",
     *     "groups" = {"chefComments"},
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when no country found"
     *   }
     * )
     *
     * @param string     $chef_id      chef Id
     * @return type
     */
    public function getChefCommentsAction( $chef_id ) {

        $em = $this->getDoctrine()->getManager();
        $apiResponse = new APIResponse();

        if($chef_id){
            $chef = $em->getRepository('KitchenBundle:User')->findOneBy(array('id'=>$chef_id));

            if($chef) {
                $apiResponse->setStatus(TRUE);
                $apiResponse->setData($chef->getRatings());
                // prepare response object with http status 200
                $view = $this->view($apiResponse, Codes::HTTP_OK);
            }
            else {
                $apiResponse->setStatus(FALSE);
                $apiResponse->setError('No chef found for the given id');
                // prepare response object with http status 404 NOT FOUND
                $view = $this->view($apiResponse, Codes::HTTP_NOT_FOUND);
            }
        }

        $context = SerializationContext::create()->setGroups(array("apiResponse", "chefComments"));
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }

    /**
     * Get All plates for certain City
     *
     * @ApiDoc(
     *   description = "Get All plates for certain city",
     *   output = {
     *     "class" = "KitchenBundle\Entity\Plate",
     *     "groups" = {"plates"},
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when no country found"
     *   }
     * )
     *
     * @param string     $city_id      city Id
     * @return type
     */
    public function getCityPlatesAction($city_id ) {

        $em = $this->getDoctrine()->getManager();
        $apiResponse = new APIResponse();

        if($city_id){
            $city = $em->getRepository('KitchenBundle:City')->findOneBy(array('id'=>$city_id));

            if($city) {
                $plates = array();
                foreach ($city->getChefs() as $chef){
                    foreach ($chef->getPlates() as $plate){
                        $plates[] = $plate;
                    }
                }
                $apiResponse->setStatus(TRUE);
                $apiResponse->setData($plates);
                // prepare response object with http status 200
                $view = $this->view($apiResponse, Codes::HTTP_OK);
            }
            else {
                $apiResponse->setStatus(FALSE);
                $apiResponse->setError('No city found for the given id');
                // prepare response object with http status 404 NOT FOUND
                $view = $this->view($apiResponse, Codes::HTTP_NOT_FOUND);
            }
        }

        $context = SerializationContext::create()->setGroups(array("apiResponse", "plates"));
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }

    /**
     * Get All categories for certain City
     *
     * @ApiDoc(
     *   description = "Get All categories for certain city",
     *   output = {
     *     "class" = "KitchenBundle\Entity\Category",
     *     "groups" = {"categories"},
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when no country found"
     *   }
     * )
     *
     * @param string     $city_id      city Id
     * @return type
     */
    public function getCityCategoriesAction($city_id ) {

        $em = $this->getDoctrine()->getManager();
        $apiResponse = new APIResponse();

        if($city_id){
            $city = $em->getRepository('KitchenBundle:City')->findOneBy(array('id'=>$city_id));

            if($city) {
                $plates     = array();
                $categories = array();
                foreach ($city->getChefs() as $chef){
                    foreach ($chef->getPlates() as $plate){
                        $plates[] = $plate;
                    }
                }
                foreach ($plates as $plate){
                    $categories[] = $plate->getCategory();
                }
                $apiResponse->setStatus(TRUE);
                $apiResponse->setData($categories);
                // prepare response object with http status 200
                $view = $this->view($apiResponse, Codes::HTTP_OK);
            }
            else {
                $apiResponse->setStatus(FALSE);
                $apiResponse->setError('No city found for the given id');
                // prepare response object with http status 404 NOT FOUND
                $view = $this->view($apiResponse, Codes::HTTP_NOT_FOUND);
            }
        }

        $context = SerializationContext::create()->setGroups(array("apiResponse", "categories"));
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }

    /**
     * Get All categories for certain Chef
     *
     * @ApiDoc(
     *   description = "Get All categories for certain Chef",
     *   output = {
     *     "class" = "KitchenBundle\Entity\Category",
     *     "groups" = {"categories"},
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when no country found"
     *   }
     * )
     *
     * @param string     $chef_id      Chef Id
     * @return type
     */
    public function getChefCategoriesAction($chef_id ) {

        $em = $this->getDoctrine()->getManager();
        $apiResponse = new APIResponse();

        if($chef_id){
            $chef = $em->getRepository('KitchenBundle:User')->findOneBy(array('id'=>$chef_id));

            if($chef) {
                $plates     = array();
                $categories = array();

                foreach ($chef->getPlates() as $plate){
                    $plates[] = $plate;
                }

                foreach ($plates as $plate){
                    if(!in_array($plate->getCategory(), $categories)){
                        $categories[] = $plate->getCategory();
                    }
                }
                $apiResponse->setStatus(TRUE);
                $apiResponse->setData($categories);
                // prepare response object with http status 200
                $view = $this->view($apiResponse, Codes::HTTP_OK);
            }
            else {
                $apiResponse->setStatus(FALSE);
                $apiResponse->setError('No city found for the given id');
                // prepare response object with http status 404 NOT FOUND
                $view = $this->view($apiResponse, Codes::HTTP_NOT_FOUND);
            }
        }

        $context = SerializationContext::create()->setGroups(array("apiResponse", "categories"));
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }

    /**
     * Get All chefs for certain City
     *
     * @ApiDoc(
     *   description = "Get All chefs for certain city",
     *   output = {
     *     "class" = "KitchenBundle\Entity\User",
     *     "groups" = {"chefs"},
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when no country found"
     *   }
     * )
     *
     * @param string     $city_id      city Id
     * @return type
     */
    public function getCityChefsAction($city_id) {

        $em = $this->getDoctrine()->getManager();
        $apiResponse = new APIResponse();

        if($city_id){
            $city = $em->getRepository('KitchenBundle:City')->findOneBy(array('id'=>$city_id));

            if($city) {
                $chefs     = array();
                $chefs = $city->getChefs();
                $apiResponse->setStatus(TRUE);
                $apiResponse->setData($chefs);
                // prepare response object with http status 200
                $view = $this->view($apiResponse, Codes::HTTP_OK);
            }
            else {
                $apiResponse->setStatus(FALSE);
                $apiResponse->setError('No city found for the given id');
                // prepare response object with http status 404 NOT FOUND
                $view = $this->view($apiResponse, Codes::HTTP_NOT_FOUND);
            }
        }

        $context = SerializationContext::create()->setGroups(array("apiResponse", "chefs"));
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }

    /**
     * Get plate
     *
     * @ApiDoc(
     *   description = "Get plate",
     *   output = {
     *     "class" = "KitchenBundle\Entity\Plate",
     *     "groups" = {"plate"},
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when no country found"
     *   }
     * )
     *
     * @param string     $plate_id      plate Id
     * @return type
     */
    public function getPlateAction($plate_id) {

        $em = $this->getDoctrine()->getManager();
        $apiResponse = new APIResponse();

        if($plate_id){
            $plate = $em->getRepository('KitchenBundle:Plate')->findOneBy(array('id'=>$plate_id));

            if($plate) {
                $apiResponse->setStatus(TRUE);
                $apiResponse->setData($plate);
                // prepare response object with http status 200
                $view = $this->view($apiResponse, Codes::HTTP_OK);
            }
            else {
                $apiResponse->setStatus(FALSE);
                $apiResponse->setError('No plate found for the given id');
                // prepare response object with http status 404 NOT FOUND
                $view = $this->view($apiResponse, Codes::HTTP_NOT_FOUND);
            }
        }

        $context = SerializationContext::create()->setGroups(array("apiResponse", "plate"));
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }

    /**
     * Get user details
     *
     * @ApiDoc(
     *   description = "Get user",
     *   output = {
     *     "class" = "KitchenBundle\Entity\User",
     *     "groups" = {"userDetails"},
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when no country found"
     *   }
     * )
     *
     * @param string     $user_id      user Id
     * @return type
     */
    public function getUserAction($user_id) {

        $em = $this->getDoctrine()->getManager();
        $apiResponse = new APIResponse();

        if($user_id){
            $user = $em->getRepository('KitchenBundle:User')->findOneBy(array('id'=>$user_id));

            if($user) {
                $apiResponse->setStatus(TRUE);
                $apiResponse->setData($user);
                // prepare response object with http status 200
                $view = $this->view($apiResponse, Codes::HTTP_OK);
            }
            else {
                $apiResponse->setStatus(FALSE);
                $apiResponse->setError('No user found for the given id');
                // prepare response object with http status 404 NOT FOUND
                $view = $this->view($apiResponse, Codes::HTTP_NOT_FOUND);
            }
        }

        $context = SerializationContext::create()->setGroups(array("apiResponse", "userDetails"));
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }

    /**
     * Get chef
     *
     * @ApiDoc(
     *   description = "Get Chef",
     *   output = {
     *     "class" = "KitchenBundle\Entity\User",
     *     "groups" = {"chef"},
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when no country found"
     *   }
     * )
     *
     * @param string     $chef_id      chef Id
     * @return type
     */
    public function getChefAction($chef_id) {

        $em = $this->getDoctrine()->getManager();
        $apiResponse = new APIResponse();

        if($chef_id){
            $chef = $em->getRepository('KitchenBundle:User')->findOneBy(array('id'=>$chef_id));

            if($chef) {
                $apiResponse->setStatus(TRUE);
                $apiResponse->setData($chef);
                // prepare response object with http status 200
                $view = $this->view($apiResponse, Codes::HTTP_OK);
            }
            else {
                $apiResponse->setStatus(FALSE);
                $apiResponse->setError('No chef found for the given id');
                // prepare response object with http status 404 NOT FOUND
                $view = $this->view($apiResponse, Codes::HTTP_NOT_FOUND);
            }
        }

        $context = SerializationContext::create()->setGroups(array("apiResponse", "chef"));
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }


    /**
     * Get Request details
     *
     * @ApiDoc(
     *   description = "Get Request details",
     *   output = {
     *     "class" = "KitchenBundle\Entity\Request",
     *     "groups" = {"requestDetails"},
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when no country found"
     *   }
     * )
     *
     * @param string     $request_id      request Id
     * @return type
     */
    public function getRequestDetailsAction($request_id) {

        $em = $this->getDoctrine()->getManager();
        $apiResponse = new APIResponse();

        if($request_id){
            $request = $em->getRepository('KitchenBundle:Request')->findOneBy(array('id'=>$request_id));

            if($request) {
                $apiResponse->setStatus(TRUE);
                $apiResponse->setData( $request );
                // prepare response object with http status 200
                $view = $this->view($apiResponse, Codes::HTTP_OK);
            }
            else {
                $apiResponse->setStatus(FALSE);
                $apiResponse->setError('No Request found for the given id');
                // prepare response object with http status 404 NOT FOUND
                $view = $this->view($apiResponse, Codes::HTTP_NOT_FOUND);
            }
        }

        $context = SerializationContext::create()->setGroups(array("apiResponse", "requestDetails"));
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }

    /**
     * Get Chef's Requests
     *
     * @ApiDoc(
     *   description = "Get Chef's Requests",
     *   output = {
     *     "class" = "KitchenBundle\Entity\Request",
     *     "groups" = {"myRequests"},
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when no country found"
     *   }
     * )
     *
     * @param string     $chef_id      chef Id
     * @return type
     */
    public function getChefRequestsAction($chef_id) {

        $em = $this->getDoctrine()->getManager();
        $apiResponse = new APIResponse();

        if($chef_id){
            $chef = $em->getRepository('KitchenBundle:User')->findOneBy(array('id'=>$chef_id));

            if($chef) {
                $apiResponse->setStatus(TRUE);
                $apiResponse->setData( $em->getRepository('KitchenBundle:Request')->findBy(array('chef'=>$chef_id, 'status'=>0)));
                // prepare response object with http status 200
                $view = $this->view($apiResponse, Codes::HTTP_OK);
            }
            else {
                $apiResponse->setStatus(FALSE);
                $apiResponse->setError('No chef found for the given id');
                // prepare response object with http status 404 NOT FOUND
                $view = $this->view($apiResponse, Codes::HTTP_NOT_FOUND);
            }
        }

        $context = SerializationContext::create()->setGroups(array("apiResponse", "myRequests"));
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }

    /**
     * Get User's Orders
     *
     * @ApiDoc(
     *   description = "Get User's Orders",
     *   output = {
     *     "class" = "KitchenBundle\Entity\Request",
     *     "groups" = {"myOrders"},
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when no country found"
     *   }
     * )
     *
     * @param string     $user_id      user Id
     * @return type
     */
    public function getUserOrdersAction($user_id) {

        $em = $this->getDoctrine()->getManager();
        $apiResponse = new APIResponse();

        if($user_id){
            $user = $em->getRepository('KitchenBundle:User')->findOneBy(array('id'=>$user_id));

            if($user) {
                $apiResponse->setStatus(TRUE);
                $apiResponse->setData($user->getOrders());
                // prepare response object with http status 200
                $view = $this->view($apiResponse, Codes::HTTP_OK);
            }
            else {
                $apiResponse->setStatus(FALSE);
                $apiResponse->setError('No user found for the given id');
                // prepare response object with http status 404 NOT FOUND
                $view = $this->view($apiResponse, Codes::HTTP_NOT_FOUND);
            }
        }

        $context = SerializationContext::create()->setGroups(array("apiResponse", "myOrders"));
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }

    /**
     * Create a Rating from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "User creates rating for chef",
     *   parameters={
     *      { "name"="user", "dataType"="integer", "required"=true, "description"="user id", "format"="" },
     *      { "name"="chef", "dataType"="integer", "required"=true, "description"="chef id", "format"="" },
     *      { "name"="time", "dataType"="integer", "required"=true, "description"="respect time", "" },
     *      { "name"="hot",  "dataType"="integer", "required"=true, "description"="food is hot", "" },
     *      { "name"="clean","dataType"="integer", "required"=true, "description"="food is clean", "" },
     *      { "name"="taste", "dataType"="integer", "required"=true, "description"="food taste", "" },
     *      { "name"="value","dataType"="integer", "required"=true, "description"="price value", "" },
     *      { "name"="comment","dataType"="text", "required"=true, "description"="comment", "" },
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the data has errors"
     *   }
     * )
     *
     * @return type
     */
    public function postRatingAction(Request $request) {
        // get parameterBag object
        $parameterBag = $request->request;
        // get entity manager
        $em = $this->getDoctrine()->getManager();

        // get Headers object
        $header = $request->headers;
        $token = $header->get('token');

        if(!$this->isTokenValid($token)){
            $apiResponse = new APIResponse(FALSE, "", 'Not Authorized');
            $view = $this->view($apiResponse, Codes::HTTP_BAD_REQUEST);

            return $this->handleView($view);
        }

        // get POST params
        $user = $parameterBag->get('user');
        $chef = $parameterBag->get('chef');
        $time = $parameterBag->get('time');
        $hot = $parameterBag->get('hot');
        $clean = $parameterBag->get('clean');
        $value = $parameterBag->get('value');
        $taste = $parameterBag->get('taste');
        $comment = $parameterBag->get('comment');

        $entity = new Rating();


        // set service properties
        $entityParams = array(
            'user'         => $user,
            'chef'         => $chef,
            'time'         => $time,
            'hot'          => $hot,
            'value'        => $value,
            'taste'        => $taste,
            'clean'        => $clean,
            'comment'      => $comment,
        );

        // create service form
        $form = $this->createForm(new RatingType(), $entity, array('csrf_protection' => false));

        // submit form against request params
        $form->submit($entityParams);

        if($form->isValid()) {

            $apiResponse = new APIResponse(TRUE);

            $em->persist($form->getData());
            $apiResponse->setData('created');
            $em->flush();

            $chef = $em->getRepository('KitchenBundle:User')->findOneBy(array('id'=>$chef));
            $rate = 0;
            foreach ($chef->getRatings() as $rating){
                $rate += ( $rating->getTime() + $rating->getClean() +$rating->getValue() +$rating->getHot() +$rating->getTaste() );
            }

            $rate = number_format($rate / 5 / count($chef->getRatings()), 2 );

            $chef->setRate($rate);
            $em->persist($chef);
            $em->flush();

            // prepare response object with http created status 201
            $view = $this->view($apiResponse, Codes::HTTP_CREATED);
        }
        else {
            // get form errors
            $errors = $this->getErrorMessages($form);

            // prepare response object with http bad request status 400
            $apiResponse = new APIResponse(FALSE, "", $errors);
            $view = $this->view($apiResponse, Codes::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }

    /**
     * Create a User/Chef from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Create a User/Chef from the submitted data",
     *   parameters={
     *      { "name"="type", "dataType"="integer", "required"=true, "description"="is it user registration or chef registration", "format"="0 => chef, 1 => user" },
     *      { "name"="username", "dataType"="string", "required"=true, "description"="", "format"="" },
     *      { "name"="email", "dataType"="string", "required"=true, "description"="", "format"="" },
     *      { "name"="mobile", "dataType"="string", "required"=true, "description"="", "" },
     *      { "name"="lat",  "dataType"="string", "required"=true, "description"="", "" },
     *      { "name"="lng","dataType"="string", "required"=true, "description"="", "" },
     *      { "name"="password", "dataType"="string", "required"=true, "description"="", "" },
     *      { "name"="name", "dataType"="string", "required"=true, "description"="", "" },
     *      { "name"="notes", "dataType"="string", "required"=true, "description"="", "" },
     *      { "name"="delivery_notes", "dataType"="string", "required"=true, "description"="", "" },
     *      { "name"="city", "dataType"="string", "required"=true, "description"="", "" },
     *      { "name"="country", "dataType"="string", "required"=true, "description"="", "" },
     *      { "name"="image", "dataType"="file", "required"=true, "description"="", "" },
     *      { "name"="user_id", "dataType"="string", "required"=false, "description"="", "" },
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the data has errors"
     *   }
     * )
     *
     * @return type
     */
    public function postRegisterAction(Request $request) {

        // get parameterBag object
        $parameterBag = $request->request;
        $fileBag      = $request->files;

        // get entity manager
        $em = $this->getDoctrine()->getManager();

        // get POST params
        $type = $parameterBag->get('type');
        $username = $parameterBag->get('username');
        $email = $parameterBag->get('email');
        $mobile = $parameterBag->get('mobile');
        $lat = $parameterBag->get('lat');
        $lng = $parameterBag->get('lng');
        $password = $parameterBag->get('password');
        $name = $parameterBag->get('name');
        $image = $fileBag->get('image');
        $notes = $parameterBag->get('notes');
        $delivery_notes = $parameterBag->get('delivery_notes');
        $city = $parameterBag->get('city');
        $country = $parameterBag->get('country');
        $user_id = $parameterBag->get('user_id');

        if($user_id){
            $entity = $em->getRepository('KitchenBundle:User')->findOneBy(array('id'=>$user_id));
        }else{
            $entity = new User();
        }



        // set service properties
        if(!$type){ //chef
            $entityParams = array(
                'name'         => $name,
                'username'     => $username,
                'email'        => $email,
                'password'     => $password,
                'mobile'       => $mobile,
                'lat'          => $lat,
                'lng'          => $lng,
                'rate'         => 0,
                'inHoliday'    => false,
                'type'         => $type,
                'notes'        => $notes,
                'deliveryNotes'=> $delivery_notes,
                'city'         => $city,
                'country'      => $country,
                'file'        => $image,
            );
        }else{ //user
            $entityParams = array(
                'username'     => $username,
                'email'        => $email,
                'password'     => $password,
                'mobile'       => $mobile,
                'lat'          => $lat,
                'lng'          => $lng,
                'rate'         => 0,
                'inHoliday'    => false,
                'city'         => $city,
                'country'      => $country,
                'type'         => $type,
            );
        }


        // create service form
        $form = $this->createForm(new UserType($type), $entity, array('csrf_protection' => false));

        // submit form against request params
        $form->submit($entityParams);

        if($form->isValid()) {

            $apiResponse = new APIResponse(TRUE);
            $obj = $form->getData();
            $em->persist($obj);
            
            if($user_id){
                $apiResponse->setData('updated');
                // prepare response object with http created status 200
                $view = $this->view($apiResponse, Codes::HTTP_OK);
            }else{
                $apiResponse->setData('created');
                // prepare response object with http created status 201
                $view = $this->view($apiResponse, Codes::HTTP_CREATED);
            }

            $em->flush();


        }
        else {
            // get form errors
            $errors = $this->getErrorMessages($form);

            // prepare response object with http bad request status 400
            $apiResponse = new APIResponse(FALSE, "", $errors);
            $view = $this->view($apiResponse, Codes::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }

    /**
     * Create a new plate.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Create a new plate",
     *   parameters={
     *      { "name"="is_hot", "dataType"="boolean", "required"=true, "description"="" },
     *      { "name"="chef", "dataType"="string", "required"=true, "description"="", "format"="" },
     *      { "name"="price", "dataType"="integer", "required"=true, "description"="", "" },
     *      { "name"="name", "dataType"="string", "required"=true, "description"="", "" },
     *      { "name"="description", "dataType"="string", "required"=true, "description"="", "" },
     *      { "name"="category", "dataType"="string", "required"=true, "description"="", "" },
     *      { "name"="image[]", "dataType"="file", "required"=true, "description"="", "" },
     *      { "name"="plate_id", "dataType"="integer", "required"=false, "description"="", "" },
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the data has errors"
     *   }
     * )
     *
     * @return type
     */
    public function postPlateAction(Request $request) {

        // get parameterBag object
        $parameterBag = $request->request;
        $fileBag = $request->files;

        // get entity manager
        $em = $this->getDoctrine()->getManager();

        // get Headers object
        $header = $request->headers;
        $token = $header->get('token');

        if(!$this->isTokenValid($token)){
            $apiResponse = new APIResponse(FALSE, "", 'Not Authorized');
            $view = $this->view($apiResponse, Codes::HTTP_BAD_REQUEST);

            return $this->handleView($view);
        }

        // get POST params
        $name = $parameterBag->get('name');
        $is_hot = $parameterBag->get('is_hot');
        $chef = $parameterBag->get('chef');
        $price = $parameterBag->get('price');
        $description = $parameterBag->get('description');
        $image = $fileBag->get('image');
        $category = $parameterBag->get('category');
        $plate_id = $parameterBag->get('plate_id');

        if($plate_id){
            $entity = $em->getRepository('KitchenBundle:Plate')->findOneBy(array('id'=>$plate_id));
        }else{
            $entity = new Plate();
        }


        $entityParams = array(
            'name'     => $name,
            'chef'     => $chef,
            'isHot'   => $is_hot,
            'price'    => $price,
            'description'    => $description,
            'category'    => $category,
            'file'    => $image[0],
        );



        // create service form
        $form = $this->createForm(new PlateType(), $entity, array('csrf_protection' => false));

        // submit form against request params
        $form->submit($entityParams);

        if($form->isValid()) {

            $apiResponse = new APIResponse(TRUE);

            $obj = $form->getData();
            $em->persist($obj);

            if($plate_id){
                $apiResponse->setData('updated');
            }else{
                $apiResponse->setData('created');
            }
            $em->flush();

            if($image){
                unset($image[0]);
                foreach ($image as $img){
                    $gallery = new Gallery();
                    $gallery->setPlate($obj);
                    $gallery->setFile($img);
                    $em->persist($gallery);
                    $em->flush();
                }
            }

            // prepare response object with http created status 201
            $view = $this->view($apiResponse, Codes::HTTP_CREATED);
        }
        else {
            // get form errors
            $errors = $this->getErrorMessages($form);

            // prepare response object with http bad request status 400
            $apiResponse = new APIResponse(FALSE, "", $errors);
            $view = $this->view($apiResponse, Codes::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }

    /**
     * Create a new report
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Create a new report",
     *   parameters={
     *      { "name"="user", "dataType"="string", "required"=true, "description"="", "format"="" },
     *      { "name"="content", "dataType"="text", "required"=true, "description"="", "" },
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the data has errors"
     *   }
     * )
     *
     * @return type
     */
    public function postReportAction(Request $request) {

        // get parameterBag object
        $parameterBag = $request->request;

        // get entity manager
        $em = $this->getDoctrine()->getManager();

        // get Headers object
        $header = $request->headers;
        $token = $header->get('token');

        if(!$this->isTokenValid($token)){
            $apiResponse = new APIResponse(FALSE, "", 'Not Authorized');
            $view = $this->view($apiResponse, Codes::HTTP_BAD_REQUEST);

            return $this->handleView($view);
        }

        // get POST params
        $user = $parameterBag->get('user');
        $content = $parameterBag->get('content');

        $entity = new Report();


        $entityParams = array(
            'user'     => $user,
            'content'     => $content
        );



        // create service form
        $form = $this->createForm(new ReportType(), $entity, array('csrf_protection' => false));

        // submit form against request params
        $form->submit($entityParams);

        if($form->isValid()) {

            $apiResponse = new APIResponse(TRUE);

            $em->persist($form->getData());
            $apiResponse->setData('created');
            $em->flush();

            // prepare response object with http created status 201
            $view = $this->view($apiResponse, Codes::HTTP_CREATED);
        }
        else {
            // get form errors
            $errors = $this->getErrorMessages($form);

            // prepare response object with http bad request status 400
            $apiResponse = new APIResponse(FALSE, "", $errors);
            $view = $this->view($apiResponse, Codes::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }

    /**
     * Create a new order for user for certain chef.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Create a new order for user for certain chef.",
     *   parameters={
     *      { "name"="user", "dataType"="string", "required"=true, "description"="" },
     *      { "name"="chef", "dataType"="string", "required"=true, "description"="", "format"="" },
     *      { "name"="delivery_date", "dataType"="date", "required"=true, "description"="", "" },
     *      { "name"="delivery_time", "dataType"="time", "required"=true, "description"="", "" },
     *      { "name"="user_lat", "dataType"="string", "required"=true, "description"="", "" },
     *      { "name"="user_lng", "dataType"="string", "required"=true, "description"="", "" },
     *      { "name"="total_price", "dataType"="string", "required"=true, "description"="", "" },
     *      { "name"="plates", "dataType"="json array", "required"=true, "description"="ex. [{'id':1,'quantity':55},{'id':2,'quantity':33}]", "" },
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the data has errors"
     *   }
     * )
     *
     * @return type
     */
    public function postRequestAction(Request $request) {

        // get parameterBag object
        $parameterBag = $request->request;

        // get entity manager
        $em = $this->getDoctrine()->getManager();

        // get Headers object
        $header = $request->headers;
        $token = $header->get('token');

        if(!$this->isTokenValid($token)){
            $apiResponse = new APIResponse(FALSE, "", 'Not Authorized');
            $view = $this->view($apiResponse, Codes::HTTP_BAD_REQUEST);

            return $this->handleView($view);
        }

        // get POST params
        $user = $parameterBag->get('user');
        $chef = $parameterBag->get('chef');
        $delivery_date = $parameterBag->get('delivery_date');
        $delivery_time = $parameterBag->get('delivery_time');
        $user_lat = $parameterBag->get('user_lat');
        $user_lng = $parameterBag->get('user_lng');
        $plates = $parameterBag->get('plates');
        $total_price = $parameterBag->get('total_price');

        $entity = new \KitchenBundle\Entity\Request();

        $entityParams = array(
            'user'          => $user,
            'chef'          => $chef,
            'deliveryDate'  => $delivery_date,
            'deliveryTime'  => $delivery_time,
            'userLat'       => $user_lat,
            'userLng'       => $user_lng,
            'status'        => 0,
            'totalPrice'    => $total_price
        );



        // create service form
        $form = $this->createForm(new RequestType(), $entity, array('csrf_protection' => false));

        // submit form against request params
        $form->submit($entityParams);

        if($form->isValid()) {

            $apiResponse = new APIResponse(TRUE);

            $obj = $form->getData();

            $apiResponse->setData('created');
//            echo json_encode(array(array('id'=>1,'quantity'=>55), array('id'=>1,'quantity'=>55)));
            $plates = json_decode($plates, true);
            foreach ($plates as $plate){
                $ent = new RequestDetails();
                $plate_obj = $em->getRepository('KitchenBundle:Plate')->findOneBy(array('id'=>$plate['id']));
                $ent->setPlate($plate_obj);
                $ent->setQuantity($plate['quantity']);
                $ent->setRequest($obj);
                $em->persist($ent);
            }
            $em->persist($obj);
            $em->flush();


            // prepare response object with http created status 201
            $view = $this->view($apiResponse, Codes::HTTP_CREATED);
        }
        else {
            // get form errors
            $errors = $this->getErrorMessages($form);

            // prepare response object with http bad request status 400
            $apiResponse = new APIResponse(FALSE, "", $errors);
            $view = $this->view($apiResponse, Codes::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }

    /**
     * Approve Request Order.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Approve Request Order.",
     *   parameters={
     *      { "name"="request", "dataType"="string", "required"=true, "description"="" },
     *      { "name"="delivery_price", "dataType"="integer", "required"=true, "description"="", "format"="" },
     *      { "name"="cancel_time", "dataType"="datetime", "required"=true, "description"="", "" },
     *      { "name"="user_mobile", "dataType"="string", "required"=true, "description"="", "" },
     *      { "name"="notes", "dataType"="string", "required"=true, "description"="", "" },
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the data has errors"
     *   }
     * )
     *
     * @return type
     */
    public function postApproveRequestAction(Request $request) {

        // get parameterBag object
        $parameterBag = $request->request;

        // get entity manager
        $em = $this->getDoctrine()->getManager();

        // get Headers object
        $header = $request->headers;
        $token = $header->get('token');

        if(!$this->isTokenValid($token)){
            $apiResponse = new APIResponse(FALSE, "", 'Not Authorized');
            $view = $this->view($apiResponse, Codes::HTTP_BAD_REQUEST);

            return $this->handleView($view);
        }

        // get POST params
        $req = $parameterBag->get('request');
        $delivery_price = $parameterBag->get('delivery_price');
        $cancel_time = $parameterBag->get('cancel_time');
        $user_mobile = $parameterBag->get('user_mobile');
        $notes = $parameterBag->get('notes');

        $em = $this->getDoctrine()->getManager();

        $req = $em->getRepository('KitchenBundle:Request')->findOneBy(array('id'=>$req));

        $apiResponse = new APIResponse();

        if($req) {
            $req->setCancelTime(new \DateTime($cancel_time));
            $req->setUserMobile($user_mobile);
            $req->setNotes($notes);
            $req->setDeliveryPrice($delivery_price);
            $req->setTotalPrice($req->getTotalPrice() + $delivery_price);
            $req->setStatus(1);
            $em->persist($req);
            $em->flush();
            $apiResponse->setStatus(TRUE);
            $apiResponse->setData('Request Approved!');

            // prepare response object with http updated status 200
            $view = $this->view($apiResponse, Codes::HTTP_OK);
        }
        else {
            $apiResponse->setStatus(FALSE);
            $apiResponse->setError('No country found for the given id');
            // prepare response object with http status 404 NOT FOUND
            $view = $this->view($apiResponse, Codes::HTTP_NOT_FOUND);
        }



        return $this->handleView($view);
    }

    /**
     * Login from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Login from the submitted data",
     *   parameters={
     *      { "name"="email", "dataType"="string", "required"=true, "description"="", "format"="" },
     *      { "name"="password", "dataType"="string", "required"=true, "description"="", "" },
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the data has errors"
     *   }
     * )
     *
     * @return type
     */
    public function postLoginAction(Request $request) {

        // get parameterBag object
        $parameterBag = $request->request;

        // get entity manager
        $em = $this->getDoctrine()->getManager();

        // get POST params
        $email = $parameterBag->get('email');
        $password = $parameterBag->get('password');

        $user = $em->getRepository('KitchenBundle:User')->findOneBy(array('email'=>$email, 'password'=>$password, 'status' => 1));

        if($user) {
            $token = md5(time()).md5(time()+$user->getId());
            $tokenValidTo = time() +  (7 * 24 * 60 * 60);
            $user->setToken($token);
            $user->setTokenValidTo($tokenValidTo);
            $em->persist($user);
            $em->flush();
            $apiResponse = new APIResponse(TRUE);

            $apiResponse->setData(array('token' => $token, 'id' => $user->getId(), 'type' => $user->getType() ? 'user' : 'chef' ));

            // prepare response object with http created status 201
            $view = $this->view($apiResponse, Codes::HTTP_ACCEPTED);
        }
        else {
            // get form errors
            // prepare response object with http bad request status 400
            $apiResponse = new APIResponse(FALSE, "", 'Wrong Credentials');
            $view = $this->view($apiResponse, Codes::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }






















    private function isTokenValid($token) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('KitchenBundle:User')->findOneBy(array('token'=>$token));
        if($user){
            if($user->getTokenValidTo() > time()){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }

    }


    private function getErrorMessages(\Symfony\Component\Form\Form $form) {
        $errors = array();

        foreach ($form->getErrors() as $key => $error) {
            if ($form->isRoot()) {
                $errors['#'][] = $error->getMessage();
            } else {
                $errors[] = $error->getMessage();
            }
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        }

        return $errors;
    }


}


