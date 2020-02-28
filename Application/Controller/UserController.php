<?php

namespace Application\Controller;
use Framework\Controller\AbstractController;
use Framework\Http\Request;
use Framework\Http\Response;

class UserController extends AbstractController
{
    /**
     * @param Request $request
     * @param array $requestAttributes
     * @return Response
     */
    public function getUser(Request $request,array $requestAttributes){

       return $this->renderer->renderView("user.phtml",$requestAttributes);
    }

    /**
     * @param Request $request
     * @param array $requestAttributes
     * @return Response
     */
    public function giveRolePriority(Request $request,array $requestAttributes){
        $message = $request->getBody()->getContents();
        $requestAttributesWithBody = array_merge($requestAttributes,['message' => $message]);

        return $this->renderer->renderView("userRole.phtml",$requestAttributesWithBody);
    }

    /**
     * @param Request $request
     * @param array $requestAttributes
     * @return Response
     */
    public function deleteUser(Request $request,array $requestAttributes){
        return $this->renderer->renderJson($requestAttributes);
    }


}
