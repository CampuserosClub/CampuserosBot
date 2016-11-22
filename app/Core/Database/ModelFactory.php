<?php

namespace CampuserosBot\Core\Database;

use Illuminate\Database\Eloquent\Factory;
use Faker\Generator as Faker;

abstract class ModelFactory
{
    /**
     * @var Factory
     */
    protected $factory;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Faker
     */
    protected $faker;

    /**
     * ModelFactory constructor.
     */
    public function __construct()
    {
        $this->factory = app()->make(Factory::class);
        $this->faker = app()->make(Faker::class);
    }

    public function define()
    {
        $this->factory->define($this->model, function () {
            return $this->fields();
        });
    }

    /**
     * @return mixed
     */
    abstract public function fields();
}