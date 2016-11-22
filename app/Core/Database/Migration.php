<?php

namespace CampuserosBot\Core\Database;

use \Illuminate\Database\Migrations\Migration as LaravelMigration;

abstract class Migration extends LaravelMigration
{
    /**
     * @var \Illuminate\Database\Schema\BuilderBuilder
     */
    protected $schema;

    /**
     * Migration constructor.
     */
    public function __construct()
    {
        $this->schema = app('db')->connection()->getSchemaBuilder();
    }
    /**
     * Run the migrations.
     *
     * @return mixed
     */
    abstract public function up();

    /**
     * Reverse the migrations.
     *
     * @return mixed
     */
    abstract public function down();
}