<?php

namespace App\Core\Framework\Route;

class Route extends \League\Route\Route
{
    public $callable;
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Get the path.
     *
     * @param array $args
     * @return string
     * @throws \Exception
     */
    public function getPath(array $args = null)
    {
        $route = $this->path;

        if($args !== null && $this->hasWildCards($route)){
            $partials = explode('/', $route);
            foreach($this->wildCards($partials) as $key=>$value) {
                if(!array_key_exists($value, $args)){
                    throw new \Exception('Missing argument for route`s wildcard {'.$value.'}');
                }
                $partials[$key] = $args[$value];
            }
            $route = implode('/', $partials);
        }

        return $route;
    }

    protected function hasWildCards($route)
    {
        return strpos($route, '{') !== false
            && strpos($route, '}') !== false
            && substr_count($route, '{') == substr_count($route, '}');
    }

    protected function wildCards(array $partials)
    {
        $wildCards = [];

        foreach ($partials as $key=>$value) {
            if($this->hasWildCards($value)) {
                $wildCards[$key] = trim($value, '{}');
            }
        }
        return $wildCards;
    }
}