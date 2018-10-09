<?php

namespace App\Services\IpLocationFetcher;

use Symfony\Component\Validator\Constraints as Assert;

class IpLocationFetcherRequest {

    /**
     * @Assert\Ip()
     */
    private $ipAddress = '';

    public function __construct(string $ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }

    public function get_ip_address(): string
    {
        return $this->ipAddress;
    }
}
