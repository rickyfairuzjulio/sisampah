<?php

namespace App\Core\Services;

abstract class BaseService
{
    /**
     * Handle the execution of the service.
     * This is a convention for single-responsibility services / action classes.
     */
    public function handle()
    {
        // Implementation provided by subclasses
    }
}
