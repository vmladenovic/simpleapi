<?php
/**
 * Created by PhpStorm.
 * User: vlada
 * Date: 4.12.17.
 * Time: 21.39
 */

namespace AppBundle\Controller\User;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use OAuth2\OAuth2ServerException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

class OAuthController extends FOSRestController
{
    /**
     * Get Access token
     *
     * @ApiDoc(
     *   resource = "AccessToken",
     *   section =  "User",
     *   requirements={
     *       {"name"="username", "dataType"="string", "requirement"="\w+", "description"="Username parameter"},
     *       {"name"="password", "dataType"="string", "requirement"="\w+", "description"="Password parameter"},
     *       {"name"="grant_type", "dataType"="string", "description"="Authentication method - password"},
     *       {"name"="client_id", "dataType"="string", "description"="API client ID"},
     *       {"name"="client_secret", "dataType"="string", "description"="API client secret"},
     *   },
     *   statusCodes={
     *         200 = "Returned when successful",
     *   }
     * )
     *
     * @param Request $request
     *
     * @return View
     */
    public function postTokenAction(Request $request)
    {
        $server = $this->get('fos_oauth_server.server');
        $user = $this->get('fos_user.user_manager')->findUserByUsernameOrEmail($request->get('username', null));

        if ($user) {
            if (!$user->isEnabled()) {
                return $this->view('User is banned', Response::HTTP_BAD_REQUEST);
            }
        }

        try {
            $data = $server->grantAccessToken($request);
            $view = $this->view($data, Response::HTTP_OK);

            return $view;
        }
        catch (OAuth2ServerException $e) {
            return $e->getHttpResponse();
        }
    }

}