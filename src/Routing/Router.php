<?php


namespace Framework\Routing;


use Framework\Contracts\RouterInterface;
use Framework\Http\Request;

class Router implements RouterInterface
{
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function route(Request $request): RouteMatch
    {
        // TODO: Implement route() method.
        $path = $request->getPath();
        foreach ($this->config as $item )
        {
            if
            (
                preg_match($this->getRegex($item["path"]), $path, $matches) &&
                $item["method"] === $request->getMethod()
            ){
                $requestAttribute = array();
                foreach ($matches as $key => $value){
                    if (preg_match("/[a-zA-Z]+/", $key)){
                        $requestAttribute[$key] = $value;
                    }
                }


                return new RouteMatch
                (
                    $item["method"],
                    $item["controllerName"],
                    $item["actionName"],
                    $requestAttribute
                );
            }

            /*
             * Create a NotFoundControoler when the path does not found
            */


        }



    }

    private function getRegex(string $path):string {
        $string = str_replace("/","\/", $path);
        $string = "/^". $string ."$/";
        return $string;
    }
}