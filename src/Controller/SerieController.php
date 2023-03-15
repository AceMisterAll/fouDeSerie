<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Service\PdoFouDeSerie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SerieController extends AbstractController
{
    //#[Route('/serie', name: 'app_serie')]
    //public function showSerie(PdoFouDeSerie $pdoFouDeSerie): Response
    //{
    //    $lesSeries = $pdoFouDeSerie->getLesSeries();
    //    $nbSeries = $pdoFouDeSerie->getNbSeries();
    //    return $this->render('serie/lesSeries.html.twig', [
    //        'lesSeries' => $lesSeries,
    //        'nbSeries' => $nbSeries,
    //    ]);
    //}

    #[Route('/serie', name: 'app_series')]
    public function showSerie(ManagerRegistry $doctrine): Response
    {
        $Repository = $doctrine->getRepository(Serie::class);
        $lesSeries = $Repository->findAll();
        dump($lesSeries);
        return $this->render('serie/lesSeries.html.twig', [
            'lesSeries' => $lesSeries
        ]);
    }

    #[Route('/serie/{id}', name: 'app_detailSerie')]
    public function detailSerie(ManagerRegistry $doctrine, $id): Response
    {
        $Repository = $doctrine->getRepository(Serie::class);
        $laSerie = $Repository->find($id);
        dump($laSerie);
        return $this->render('serie/detailSerie.html.twig', [
            'laSerie' => $laSerie
        ]);
    }

    #[Route('/api/{id}/like', name: 'app_api_serie_like')]
    public function getLikeOneSerie($id, ManagerRegistry $doctrine): Response
    {
        $Repository = $doctrine->getRepository(Serie::class);
        $laSerie = $Repository->find($id);
        $nblike = $laSerie->getNblike();
        $nblike = $nblike + 1;
        $laSerie->setNblike($nblike);
        $entityManager = $doctrine->getManager();
        $entityManager->persist($laSerie);
        $entityManager->flush();

        $TabSerie =
                [
                    'id' => $laSerie -> getId(),
                    'titre' => $laSerie -> getTitre(),
                    'nb_like' => $laSerie -> getNblike(),
                ];
        return new JsonResponse($TabSerie, 200);
    }
}
