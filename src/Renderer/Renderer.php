<?php


namespace Framework\Renderer;


use Framework\Contracts\RendererInterface;
use Framework\Http\Response;
use Framework\Http\Stream;

class Renderer implements RendererInterface
{
    private $baseViewsPath;
    private $template;

    public function __construct(string $baseViewsPath, string $template)
    {
        $this->baseViewsPath =$baseViewsPath;
        $this->template = $template;
    }

    /**
     * @inheritDoc
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
     * @inheritDoc
     */
    public function renderJson(array $data): Response
    {
        $json = json_encode($data);
        $stream = Stream::createFromString($json);
        $response = new Response($stream);

        return $response;
    }
}