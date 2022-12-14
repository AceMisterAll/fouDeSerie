<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Entity\Serie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
    #[Route('/testGenre', name: 'app_genre')]
    public function testGenre(ManagerRegistry $doctrine): Response
    {
        $unGenre = new Genre();
        $unGenre->setLibelle("Drames");
        $Repository = $doctrine->getRepository(Serie::class);
        $laSerie = $Repository->find(2);
        $laSerie->addSerie($unGenre);
        $entityManager = $doctrine->getManager();
        $entityManager->persist($unGenre);
        $entityManager->flush();


        return $this->render('genre/index.html.twig', [
            'laSerie' => $laSerie,
        ]);
    }
}
