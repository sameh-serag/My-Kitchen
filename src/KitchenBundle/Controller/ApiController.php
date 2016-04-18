<?php

namespace KitchenBundle\Controller;

use KitchenBundle\Entity\Rating;
use KitchenBundle\Entity\User;

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

use KitchenBundle\Utils\APIResponse;
use KitchenBundle\Utils\APIError;


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
     * Get All plates for certain City
     *
     * @ApiDoc(
     *   description = "Get All plates for certain city",
     *   output = {
     *     "class" = "KitchenBundle\Entity\Plates",
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
                $apiResponse->setData($chef->getRequests());
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
            $apiResponse = new APIResponse(FALSE, NULL, 'Not Authorized');
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
            $apiResponse = new APIResponse(FALSE, NULL, $errors);
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
     *      { "name"="type", "dataType"="integer", "required"=true, "description"="is it user registration or chef registration", "format"="0 => user, 1 => chef" },
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
     *      { "name"="image", "dataType"="string", "required"=true, "description"="", "" },
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
        $image = $parameterBag->get('image');
        $notes = $parameterBag->get('notes');
        $delivery_notes = $parameterBag->get('delivery_notes');
        $city = $parameterBag->get('city');

        $entity = new User();


        // set service properties
     if($type){ //chef
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
             'notes'         => $notes,
             'deliveryNotes' => $delivery_notes,
             'city'         => $city,
             'image'         => $image,
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
             'type'         => $type,
         );
     }


        // create service form
        $form = $this->createForm(new UserType($type), $entity, array('csrf_protection' => false));

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
            $apiResponse = new APIResponse(FALSE, NULL, $errors);
            $view = $this->view($apiResponse, Codes::HTTP_BAD_REQUEST);
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

        $user = $em->getRepository('KitchenBundle:User')->findOneBy(array('email'=>$email, 'password'=>$password));

        if($user) {
            $token = md5(time()).md5(time()+$user->getId());
            $tokenValidTo = time() +  (7 * 24 * 60 * 60);
            $user->setToken($token);
            $user->setTokenValidTo($tokenValidTo);
            $em->persist($user);
            $em->flush();
            $apiResponse = new APIResponse(TRUE);

            $apiResponse->setData(array('token' => $token, 'type' => $user->getType() ? 'user' : 'chef' ));

            // prepare response object with http created status 201
            $view = $this->view($apiResponse, Codes::HTTP_ACCEPTED);
        }
        else {
            // get form errors
            // prepare response object with http bad request status 400
            $apiResponse = new APIResponse(FALSE, NULL, 'Wrong Credentials');
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
