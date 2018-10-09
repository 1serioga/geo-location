<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="app_default")
     */
    public function index(Request $request)
    {
        return $this->render('default.html.twig', [
            'userIp' => $request->getClientIp(),
        ]);
    }
}
