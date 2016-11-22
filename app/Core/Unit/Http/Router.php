<?php

namespace CampuserosBot\Core\Unit\Http;

use Illuminate\Routing\Router as LaravelRouter;

abstract class Router extends LaravelRouter
{
    /**
     * @var LaravelRouter
     */
    protected $router;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * Router constructor.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->router = app('router');
        $this->options = $options;
    }

    /**
     * Register Routes.
     */
    public function register()
    {
        $this->router->group($this->options, function () {
            $this->routes();
        });
    }

    /**
     * Define routes.
     *
     * @return mixed
     */
    abstract public function routes();
}