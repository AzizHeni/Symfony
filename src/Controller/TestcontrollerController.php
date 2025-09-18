<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TestcontrollerController extends AbstractController
{
    #[Route('/testcontroller', name: 'app_testcontroller')]
    public function index(): Response
    {
        return $this->render('testcontroller/index.html.twig', [
            'controller_name' => 'TestcontrollerController',
        ]);
    }
}
