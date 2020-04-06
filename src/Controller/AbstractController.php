<?php
declare(strict_types=1);

namespace Framework\Controller;

use Framework\Contracts\RendererInterface;
use Framework\Http\Message;
use Framework\Http\Response;
use Framework\Http\Stream;

/**
 * Base abstract class for application controllers.
 * All application controllers must extend this class.
 */
abstract class AbstractController
{
    const PAGESIZE = 5;
    /**
     * @var RendererInterface
     */
    protected $renderer;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    protected function redirect(string $location) : Response
    {
        $response = new Response(Stream::createFromString(''));
        $response = $response->withStatus(301);
        $response = $response->withHeader('Location', $location);

        return $response;
    }

    protected function alertMessage($message)
    {
        echo '<script language="javascript">';
        echo "alert('$message')";
        echo '</script>';
    }

}
