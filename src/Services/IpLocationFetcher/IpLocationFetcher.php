<?php

namespace App\Services\IpLocationFetcher;


use App\Entity\IpLocation;
use App\Repository\IpLocationRepository;
use App\Services\IpLocationProvider\IpLocationProvider;
use Doctrine\ORM\EntityManagerInterface;

class IpLocationFetcher {

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

    public function __construct(
        IpLocationRepository $ipLocationRepository,
        IpLocationProvider $ipLocationProvider,
        EntityManagerInterface $entityManager
    )
    {
        $this->ipLocationRepository = $ipLocationRepository;
        $this->ipLocationProvider = $ipLocationProvider;
        $this->entityManager = $entityManager;
    }

    public function fetch(IpLocationFetcherRequest $ipLocationFetcherRequest): IpLocation
    {
        $ipLocation = $this->ipLocationRepository->findOneBy([
            'ipAddress' => $ipLocationFetcherRequest->get_ip_address(),
        ]);
        if ($ipLocation instanceof IpLocation) {
            return $ipLocation;
        }
        $response = $this->ipLocationProvider->provide($ipLocationFetcherRequest->get_ip_address());
        $ipLocation = new IpLocation($ipLocationFetcherRequest->get_ip_address());
        $ipLocation->setCity($response->getCity());
        $ipLocation->setCountry($response->getCountry());
        $this->entityManager->persist($ipLocation);
        $this->entityManager->flush();
        return $ipLocation;
    }

}
