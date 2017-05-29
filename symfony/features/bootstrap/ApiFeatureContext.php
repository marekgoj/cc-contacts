<?php

use Imbo\BehatApiExtension\Context\ApiContext;

/**
 * Defines application features from the specific context.
 */
class ApiFeatureContext extends ApiContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }
}
