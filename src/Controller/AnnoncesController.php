<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Entity\GPostule;
use App\Form\AnnoncesType;
use App\Repository\AnnoncesRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Attribute\Route;

class AnnoncesController extends AbstractController
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly AnnoncesRepository $annoncesRepository,
    ) {}

    #[Route('/annonces', name: 'app_annonces')]
    public function index(Request $request): Response
    {

        $annonce = new Annonces();

        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $img = $form->get('img')->getData();

            $imgName = uniqid() . "." . $img->guessExtension();
            $img->move("img/", $imgName);
            $annonce->setImg($imgName);

            $annonce->setUser($this->getUser());

            $this->entityManager->persist($annonce);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_annonces');
        }

        return $this->render('annonces/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/annonces/modif/{id}', name: 'app_annonces_modify')]
    public function modif(int $id, Request $request, Session $session): Response
    {
        $annonce = $this->annoncesRepository->find($id);

        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $img = $form->get('img')->getData();

            if ($img) {
                $file = new Filesystem();
                $file->remove("img/" . $annonce->getImg());

                $imgName = uniqid() . "." . $img->guessExtension();
                $img->move("img/", $imgName);
                $annonce->setImg($imgName);
            }

            $this->entityManager->persist($annonce);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_annonces');
        }

        return $this->render('annonces/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/annonces/supp/{id}', name: 'app_annonces_supp')]
    public function supp(int $id, Request $request): Response
    {
        $annonce = $this->annoncesRepository->find($id);

        $file = new Filesystem();
        $file->remove("img/" . $annonce->getImg());

        $this->entityManager->remove($annonce);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_main');
    }

    #[Route('/annonces/gPostule/{id}', name: 'app_postule')]
    public function gPostule(int $id, Request $request, Session $session): Response
    {
        $annonce = $this->annoncesRepository->find($id);

        $gPostule = new GPostule();
        $gPostule->setAnnonce($annonce);
        $gPostule->setUser($this->getUser());

        $this->entityManager->persist($gPostule);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_main');
    }
}
