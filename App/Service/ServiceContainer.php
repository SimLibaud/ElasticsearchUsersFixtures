<?php

namespace App\Service;

use App\Configuration\Configuration;
use App\Service\UserFactory;

class ServiceContainer
{

    private $container;

    public function __construct()
    {
        $this->container['configuration'] = new Configuration();
        $this->container['user-factory'] = new UserFactory(
            $this->container['configuration']->get('elasticsearch')['host'],
            $this->container['configuration']->get('elasticsearch')['port']
        );
    }

    public function get($service_name)
    {

        if (false === array_key_exists($service_name, $this->container)) {
            throw new \LogicException(sprintf('The service "%s" doesn\' exist', $service_name));
        }

        return $this->container[$service_name];
    }

}