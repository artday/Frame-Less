<?php
namespace App\Core\Framework\Request;

class ServerRequest extends \Zend\Diactoros\ServerRequest
{
    /**
     * Proxy to receive the request method.
     *
     * This overrides the parent functionality to ensure the method is never
     * empty; if no method is present, it returns 'GET'.
     *
     * @return string
     */
    public function getMethod()
    {
        $method = parent::getMethod();

        if (in_array($method, $this->allowedToOverride())
            && in_array($this->getParsedBody()[$this->overrideMethodToken()], $this->overrideMethods())) {
            return $this->getParsedBody()[$this->overrideMethodToken()];
        }
        return $method;
    }

    private function allowedToOverride()
    {
        return ['POST'];
    }

    private function overrideMethods()
    {
        return ['PUT', 'PATCH', 'DELETE'];
    }

    private function overrideMethodToken()
    {
        return '_method';
    }

    public function getReferer()
    {
        return $this->getHeader('referer')[0];
    }

    public function all()
    {
        return array_filter($this->getParsedBody(),
            function($key){
                return !in_array($key, $this->hiddenParams());
            }, ARRAY_FILTER_USE_KEY);
    }

    private function hiddenParams()
    {
        return ['_method', 'csrf-token'];
    }

}