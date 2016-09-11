<?php

namespace App\Configuration;

class Configuration
{

    private $elasticsearch = [
        'host'  => '192.168.1.22',
        'port'  => 9200
    ];

    public function get($arg_name)
    {
        if (false === property_exists($this, $arg_name)) {
            throw new \InvalidArgumentException(sprintf('The parameter "%s" is not defined in your configuration', $arg_name));
        }

        return $this->{$arg_name};
    }

}