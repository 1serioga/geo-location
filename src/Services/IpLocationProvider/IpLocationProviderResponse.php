<?php

namespace App\Services\IpLocationProvider;

class IpLocationProviderResponse {

    /**
     * @var string
     */
    private $ipAddress;
    /**
     * @var string
     */
    private $city;
    /**
     * @var string
     */
    private $country;

    public function __construct(string $ipAddress, string $city, string $country)
    {
        $this->ipAddress = $ipAddress;
        $this->city = $city;
        $this->country = $country;
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}
