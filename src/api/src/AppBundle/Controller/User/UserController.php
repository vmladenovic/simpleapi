<?php

namespace AppBundle\Controller\User;

use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

/**
 * Created by PhpStorm.
 * User: vlada
 * Date: 3.12.17.
 * Time: 11.24
 */
class UserController extends FOSRestController
{
    /**
     * Get list of all users.
     *
     * @ApiDoc(
     *   resource = "User",
     *   section = "User",
     *   requirements={
     *      {"name"="limit", "dataType"="integer", "requirement"="\d+", "description"="the max number of records to return"}
     *   },
     *   parameters={
     *      {"name"="limit", "dataType"="integer", "required"=false, "description"="the max number of records to return"},
     *      {"name"="offset", "dataType"="integer", "required"=false, "description"="the record number to start results at"}
     *   },
     *   statusCodes={
     *         200 = "Returned when successful",
     *   }
     * )
     *
     * @QueryParam(name="limit", requirements="\d+", default="10", description="our limit")
     * @QueryParam(name="offset", requirements="\d+", nullable=true, default="0", description="our offset")
     * @QueryParam(name="sort", requirements="(id|name)", nullable=true, strict=true, default="id", description="Sort by field (id|name)")
     * @QueryParam(name="direction", requirements="(ASC|DESC)", nullable=true, strict=true, default="DESC", description="Sorting direction")
     *
     * @return View
     */

    public function getListAction($limit, $offset, $sort, $direction)
    {
        $context = new Context();
        $users = $this->getDoctrine()->getRepository('AppBundle:User\User')->findAll();
        $count = count($users);
        $context->addGroup('public');
        $view = $this->view($users, Response::HTTP_OK);
        $view->setContext($context);

        $view->setHeader('X-Total-Count', $count);

        return $view;
    }


}