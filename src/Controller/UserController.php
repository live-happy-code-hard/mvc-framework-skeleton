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
        $requestAttributes["p"] = $request->getParameter("p");
        $requestAttributes["body"] = $request->getBody()->getContents();

        return $this->renderer->renderView('/userPost.phtml',$requestAttributes);
    }

    public function deleteUser(Request $request, array $requestAttributes){

        $sendArray["message"] = "Delete user with id ".$requestAttributes["id"];
        return $this->renderer->renderJson($sendArray);
    }
}