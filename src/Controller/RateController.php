<?php

namespace App\Controller;

use App\Service\RateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RateController extends AbstractController
{
    private RateService $service;

    public function __construct(RateService $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("/rate", name="app_rate")
     */
    public function getCourse(Request $request): Response
    {
        $course = $this->service->getCourse(
            $request->get('dateStart'),
            $request->get('dateEnd'),
            $request->get('code')
        );

        return $this->json($course);
    }

    /**
     * @Route("/rate/add", name="app_rate_add")
     */
    public function addRate(): Response
    {
        $this->service->sendRequest();

        return new Response('Rate successfully added');
    }
}
