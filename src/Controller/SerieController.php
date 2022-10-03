<?php

namespace App\Controller;

use App\Service\PdoFouDeSerie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SerieController extends AbstractController
{
    #[Route('/serie', name: 'app_serie')]
    public function showSerie(PdoFouDeSerie $pdoFouDeSerie): Response
    {
        $lesSeries = $pdoFouDeSerie->getLesSeries();
        $nbSeries = $pdoFouDeSerie->getNbSeries();
        return $this->render('serie/lesSeries.html.twig', [
            'lesSeries' => $lesSeries,
            'nbSeries' => $nbSeries,
        ]);
    }
}
