<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\VacanciesParseQuery;
use App\Repository\UserRepository;
use App\Repository\VacanciesParseQueryRepository;
use App\Service\GetIndustriesService;
use App\Service\ParserService\AdapterService;
use App\Service\ParserService\ParserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{


    #[Route('/', name: 'index')]
    public function index(
    )
    {
        return $this->redirectToRoute('app_login');
    }
}