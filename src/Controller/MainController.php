<?php

namespace App\Controller;

use App\Repository\AnnoncesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{

    public function __construct(
        private readonly AnnoncesRepository $annoncesRepository,
    ){}

    #[Route('/', name: 'app_main')]
    public function index(Session $session): Response
    {

        $annonces = $this->annoncesRepository->findAll();

        return $this->render('main/index.html.twig', [
            'annonces' => $annonces,
        ]);
    }
}
