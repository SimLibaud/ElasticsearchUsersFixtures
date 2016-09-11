<?php

namespace App\Service;

use Elasticsearch\ClientBuilder;
use Faker\Factory;

class UserFactory
{

    private $faker;
    private $db_host;
    private $db_port;
    private $client;

    public function __construct($db_host, $db_port)
    {
        $this->faker = Factory::create();
        $this->db_host = $db_host;
        $this->db_port = $db_port;
        $this->client = ClientBuilder::create()->setHosts([$this->db_host.':'.$this->db_port])->build();
    }

    /**
     * Add users do the elasticsearch Database
     *
     * @param integer $number_users
     * @return mixed
     */
    public function loadUsers($number_users = 10)
    {
        $data = [];
        for ($x=0; $x < $number_users; $x++) {
            $data['body'][] = [
                'index' => [
                    '_index'    => 'oewifi',
                    '_type'     => 'users'
                ]
            ];

            $data['body'][] = [
                'firstname'     => $this->faker->firstName,
                'lastname'      => $this->faker->lastName,
                'age'           => $this->faker->numberBetween(18, 80),
                'country'       => $this->faker->countryCode,
                'user-agent'    => $this->faker->userAgent,
                'upload'        => $this->faker->numberBetween(50, 100000),
                'download'      => $this->faker->numberBetween(1000, 100000),
                'date'          => $this->faker->dateTime,
                'auth_type'     => $this->faker->randomElement(['facebook', 'twitter', 'linkedin', 'portail'])
            ];

            if ($x % 1000 === 0) {
                $this->client->bulk($data);
                $data = [];
            }
        }
        if (!empty($data['body'])) {
            $this->client->bulk($data);
        }

        return $number_users;
    }


}