<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgreeablePuppyController extends AbstractController
{
    #[Route('/agreeable/puppy', name: 'app_agreeable_puppy')]
    public function index(): Response
    {
        return $this->render('agreeable_puppy/index.html.twig', [
            'controller_name' => 'AgreeablePuppyController',
        ]);
    }
}
