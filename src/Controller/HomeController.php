<?php

namespace App\Controller;

use App\DTO\SearchDto;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(#[MapQueryString()] ?SearchDto $searchDto = null): Response
    {
        return $this->render('home/index.html.twig', [
            'searchDto' => $searchDto,
        ]);
    }
}
