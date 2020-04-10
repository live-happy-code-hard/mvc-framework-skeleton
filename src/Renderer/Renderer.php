<?php


namespace Framework\Renderer;


use Framework\Contracts\RendererInterface;
use Framework\Http\Response;
use Framework\Http\Stream;

class Renderer implements RendererInterface
{
    /**
     * @var string
     */
    private $baseViewsPath;

    /**
     * @var string
     */
    private $template;

    public function __construct(string $baseViewsPath, string $template)
    {
        $this->baseViewsPath = APP_PATH . $baseViewsPath;
        $this->template = APP_PATH . $template;
    }

    /**
     * @param string $viewFile
     * @param array $arguments
     * @return Response
     */

    public function renderView(string $viewFile, array $arguments): Response
    {
        ob_start();

        extract($arguments);
        $fullPath = $this->baseViewsPath . $viewFile;
        require $this->template;

        $content = ob_get_contents();

        ob_get_clean();

        $stream = Stream::createFromString($content);

        $response = new Response($stream);

        return $response;

    }

    /**
     * @param array $data
     * @return Response
     */

    public function renderJson(array $data): Response
    {
        $json = json_encode($data);
        $stream = Stream::createFromString($json);
        $response = new Response($stream);

        return $response;
    }
}