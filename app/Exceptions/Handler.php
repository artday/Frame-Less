<?php

namespace App\Exceptions;

use Exception;
use App\Views\View;
use ReflectionClass;
use App\Session\SessionStore;
use Psr\Http\Message\ResponseInterface;

class Handler
{
    protected $exception;
    protected $session;
    protected $view;
    protected $response;

    public function __construct(
        Exception $exception,
        SessionStore $session,
        ResponseInterface $response,
        View $view
    ) {
        $this->exception = $exception;
        $this->session = $session;
        $this->response = $response;
        $this->view = $view;
    }

    public function respond()
    {
        $class = (new ReflectionClass($this->exception))->getShortName();

        if (method_exists($this, $method = "handle{$class}")) {
            return $this->{$method}($this->exception);
        }

        return $this->unhandleException($this->exception);
    }

    protected function handleValidationException(ValidationException $e)
    {
        $this->session->set([
            'errors' => $e->getErrors(),
            'old' => $e->getOldInput()
        ]);
        return redirect($e->getPath());
    }

    protected function handleCsrfTokenException(CsrfTokenException $e)
    {
        return $this->view->render($this->response, 'errors/csrf.twig');
    }

    protected function handleNotFoundException()
    {
        return $this->view->render($this->response, 'errors/404.twig');
    }

    /**
     * @param Exception $e
     * @return ResponseInterface
     * @throws Exception
     */
    protected function unhandleException(Exception $e)
    {
        if(env('APP_DEBUG')){
            throw $e;
        }
        return $this->handleNotFoundException();
    }

}