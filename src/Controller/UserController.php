<?php


namespace Framework\Controller;


use Framework\Http\Request;

class UserController extends AbstractController
{
    /**
     * @param Request $request
     * @param array $requestAttributes
     * @return \Framework\Http\Response
     */
    public function getUser(Request $request, array $requestAttributes){
        return $this->renderer->renderJson($requestAttributes);
    }

    public function postUser(Request $request, array $requestAttributes){
        return $this->renderer->renderJson($requestAttributes);
    }
}