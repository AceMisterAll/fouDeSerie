<?php

namespace App\Controller;

use App\Service\PdoFouDeSerie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api/series', name: 'app_api_series')]
    public function getListeSeries(PdoFouDeSerie $pdoFouDeSerie): Response
    {
        $lesSeries = $pdoFouDeSerie->getLesSeries();
        dump($lesSeries);
        $TabSeries = [];
        foreach ($lesSeries as $uneserie) {
            $TabSeries[] = [
                'id' => $uneserie['id'],
                'titre' => $uneserie['titre']
            ];
        }
        return new JsonResponse($TabSeries);
    }
}
