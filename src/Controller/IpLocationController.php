<?php

namespace App\Controller;

use App\Services\IpLocationFetcher\IpLocationFetcher;
use App\Services\IpLocationFetcher\IpLocationFetcherRequest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class IpLocationController extends Controller
{
    /**
     * @Route("/api/ip-location", name="app_ip_location")
     */
    public function index(Request $request, IpLocationFetcher $ipLocationFetcher, ValidatorInterface $validator)
    {
        $ipLocationFetcheRequest = new IpLocationFetcherRequest((string) $request->query->get('ipAddress'));
        $errors = $validator->validate($ipLocationFetcheRequest);
        if (count($errors) > 0) {
            return $this->json([
                'errors' => $errors,
            ], 400);
        }
        $ipLocation = $ipLocationFetcher->fetch($ipLocationFetcheRequest);
        return $this->json([
            'city' => $ipLocation->getCity(),
            'country' => $ipLocation->getCountry(),
        ]);
    }
}
