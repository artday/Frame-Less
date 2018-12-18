<?php

namespace App\Config;

use App\Config\Loaders\Loader;

class Config
{
    protected $config = [];
    protected $cache = [];

    public function load(array $loaders)
    {
        foreach ($loaders as $loader) {
            if (!$loader instanceof Loader) {
                continue;
            }
            $this->config = array_merge($this->config, $loader->parse());
        }
        return $this;
    }

    public function get($key, $default = null)
    {
        if ($this->existsInCache($key)) {
            return $this->fromCache($key);
        }

        $value = $this->extractFromConfig($key);

        return $value
            ? $this->addToCache($key, $value)
            : $this->addToCache($key, $default);
    }

    protected function existsInCache($key)
    {
        return isset($this->cache[$key]);
    }

    protected function fromCache($key)
    {
        return $this->cache[$key];
    }

    protected function extractFromConfig($key)
    {
        $filtered = $this->config;
        foreach (explode('.', $key) as $segment) {
            if (array_key_exists($segment, $filtered)) {
                $filtered = $filtered[$segment];
                continue;
            }
            return;
        }
        return $filtered;
    }

    protected function addToCache($key, $value)
    {
        $this->cache[$key] = $value;
        return $value;
    }

}