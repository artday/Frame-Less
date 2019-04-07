<?php
namespace App\Core\Framework\Route;

trait RouteCollectionResourceTrait
{
    protected $pendingResourceRegistration = [];

    protected $resourceDefaults = ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'];

//    protected $lastCreatedResourceHandler = null;

    protected function getVerbMethod($verb)
    {
        switch ($verb) {
            case 'store': return 'post'; break;
            case 'update': return 'patch'; break;
            case 'destroy': return 'delete'; break;
            default: return 'get';
        }
    }

    protected function verbHasWildcard($verb)
    {
        return in_array($verb, ['show', 'edit', 'update', 'destroy']);
    }

    protected function getVerbPath($path, $verb)
    {
        if (in_array($verb, ['index', 'store'])) {
            return $path;
        }
        if ($this->verbHasWildcard($verb)){
            $path = $path . '/{id}';
        }
        return in_array($verb, ['create', 'edit']) ?
            $path . '/' . $verb : $path;
    }

    protected function resolvePendingResource()
    {
//        dd(new \ReflectionClass($this));
        foreach ($this->pendingResourceRegistration as $resource) {
//            dd($resource);
            $this->{$resource['method']}($resource['path'], $resource['handler'])
                ->setName($resource['name']);
        }

    }

    public function resource($path, $handler, $resource_name)
    {
        foreach ($this->resourceDefaults as $verb) {
            $this->pendingResourceRegistration[] = [
                'method' => $this->getVerbMethod($verb),
                'path' => $this->getVerbPath($path, $verb),
                'handler' => $handler . '::' . $verb,
                'name' => $resource_name . '.' . $verb
            ];
        }

        /*$this->get($path, $handler . '::index')->setName($resource_name . '.index');
        $this->get($path . '/create', $handler . '::create')->setName($resource_name . '.create');
        $this->post($path, $handler . '::store')->setName($resource_name . '.store');
        $this->get($path . '/{id}', $handler . '::show')->setName($resource_name . '.show');
        $this->get($path . '/{id}/edit', $handler . '::edit')->setName($resource_name . '.edit');
        $this->patch($path . '/{id}', $handler . '::update')->setName($resource_name . '.update');
        $this->delete($path . '/{id}', $handler . '::destroy')->setName($resource_name . '.destroy');*/


//        $this->lastCreatedResourceHandler = $handler;
//        dd($this->pendingResourceRegistration, 'hello');
        return $this;
    }

    public function except(array $methods)
    {
//        foreach ($methods as $method) {
//            $this->deleteRoute($this->lastCreatedResourceHandler . '::' . $method);
//        }
    }

}