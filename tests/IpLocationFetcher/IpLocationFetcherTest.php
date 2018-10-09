<?php

namespace App\Tests\Util;

use App\Entity\IpLocation;
use App\Repository\IpLocationRepository;
use App\Services\IpLocationFetcher\IpLocationFetcher;
use App\Services\IpLocationFetcher\IpLocationFetcherRequest;
use App\Services\IpLocationProvider\IpLocationProvider;
use App\Services\IpLocationProvider\IpLocationProviderResponse;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class IpLocationFetcherTest extends TestCase
{
    /**
     * @var IpLocationRepository
     */
    private $ipLocationRepository;
    /**
     * @var IpLocationProvider
     */
    private $ipLocationProvider;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function setUp()
    {
        $this->ipLocationRepository = $this->prophesize(IpLocationRepository::class);
        $this->ipLocationProvider = $this->prophesize(IpLocationProvider::class);
        $this->entityManager = $this->prophesize(EntityManagerInterface::class);
    }

    public function testItShouldReturnCachedDataIfExists()
    {
        $ipLocation = $this->prophesize(IpLocation::class);
        $this->ipLocationRepository->findOneBy(Argument::type('array'))->willReturn(
            $ipLocation->reveal()
        );
        $res = $this->get_fetcher()->fetch(new IpLocationFetcherRequest('127.0.0.1'));
        $this->assertInstanceOf(IpLocation::class, $res);
    }

    public function testItShouldReturnDataFromProviderIfNoCache()
    {
        $response = $this->prophesize(IpLocationProviderResponse::class);
        $this->ipLocationRepository->findOneBy(Argument::type('array'))->willReturn(null);
        $response->getCity()->willReturn('city');
        $response->getCountry()->willReturn('country');
        $this->ipLocationProvider->provide(Argument::type('string'))->willReturn(
            $response->reveal()
        );
        $res = $this->get_fetcher()->fetch(new IpLocationFetcherRequest('127.0.0.1'));
        $this->assertInstanceOf(IpLocation::class, $res);
        $this->assertEquals('city', $res->getCity());
        $this->assertEquals('country', $res->getCountry());
    }

    private function get_fetcher() {
        return new IpLocationFetcher(
            $this->ipLocationRepository->reveal(),
            $this->ipLocationProvider->reveal(),
            $this->entityManager->reveal()
        );
    }
}
