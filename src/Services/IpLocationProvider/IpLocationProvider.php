<?php

namespace App\Services\IpLocationProvider;

use ipinfo\ipinfo\IPinfo;

class IpLocationProvider {

    /**
     * @var IPinfo
     */
    private $client;

    public function __construct(string $infoIpSecret)
    {
        $this->client = new IPinfo($infoIpSecret);
    }

    public function provide(string $ipAddress): IpLocationProviderResponse
    {
        $details = $this->client->getDetails($ipAddress);
        if (isset($details->city) && isset($details->country_name)) {
            return new IpLocationProviderResponse($ipAddress, $details->city, $details->country_name);
        }
        return new IpLocationProviderResponse($ipAddress, '', '');
    }

}
