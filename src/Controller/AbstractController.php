<?php
declare(strict_types=1);

namespace Framework\Controller;

use Framework\Contracts\RendererInterface;
use Framework\Http\Message;
use Framework\Http\Response;
use Framework\Http\Stream;
use Psr\Http\Message\MessageInterface;

/**
 * Base abstract class for application controllers.
 * All application controllers must extend this class.
 */
abstract class AbstractController
{
    /**
     * @var RendererInterface
     */
    protected $renderer;

    /**
     * AbstractController constructor.
     * @param RendererInterface $renderer
     */
    public function __construct(RendererInterface $renderer)
    {
        // Rendered gets constructor injected
        $this->renderer = $renderer;
    }

    /**
     * @param $session
     * @return Message|MessageInterface
     */
    public function verifySessionUserName($session)
    {
        if (!$session->get('name')) {
            $session->set('errorMessages', []);
            $body = Stream::createFromString("");
            $responseWithoutHeader = new Response($body, '1.1', 301);
            $response = $responseWithoutHeader->withHeader('Location', 'http://quizApp.com');

            return $response;
        }
    }

    // TODO: inject other services: session handling, mail sending, etc. into the actual controllers where needed
}
