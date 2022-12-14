<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Service\PdoFouDeSerie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
