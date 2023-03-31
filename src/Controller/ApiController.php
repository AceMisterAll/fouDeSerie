<?php

namespace App\Controller;

use App\Service\PdoFouDeSerie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotNull;

class ApiController extends AbstractController
{
    #[Route('/api/series', name: 'app_api_series', methods: ['GET'])]
    public function getListeSeries(PdoFouDeSerie $pdoFouDeSerie): Response
    {
        $lesSeries = $pdoFouDeSerie->getLesSeries();
        $TabSeries = [];
        foreach ($lesSeries as $uneserie) {
            $TabSeries[] = [
                'id' => $uneserie['id'],
                'titre' => $uneserie['titre']
            ];
        }
        return new JsonResponse($TabSeries);
    }

    #[Route('/api/series/{id}', name: 'app_api_series_id', methods: ['GET'])]
    public function getUneSerie(PdoFouDeSerie $pdoFouDeSerie, $id): Response
    {
        $uneSerie = $pdoFouDeSerie->getUneSerie($id);
        if ($uneSerie) {
            $TabSerie = [
                'id' => $uneSerie['id'],
                'titre' => $uneSerie['titre'],
                'resume' => $uneSerie['resume'],
                'duree' => $uneSerie['duree']
            ];
            return new JsonResponse($TabSerie);
        } else {
            return new JsonResponse(['message' => 'Serie inexistante'], 404);
        }
    }

    #[Route('/api/series', name: 'app_api_newSerie', methods: ['POST'])]
    public function newSerie(Request $request, PdoFouDeSerie $pdoFouDeSerie)
    {
        $content = $request->getContent();
        if (!empty($content)) {
            $laserie = json_decode($content, true);
            $laSerieAjouter = $pdoFouDeSerie->setLaSerie($laserie);
            $tabJson =
                [
                    'id' => $laSerieAjouter['id'],
                    'titre' => $laSerieAjouter['titre'],
                    'resume' => $laSerieAjouter['resume'],
                    'duree' => $laSerieAjouter['duree'],
                    'premiereDiffusion' => $laSerieAjouter['premiereDiffusion'],
                ];
        }
        return new JsonResponse($tabJson, Response::HTTP_CREATED);
    }

    #[Route('/api/series/{id}', name: 'app_api_series_delete', methods: ['DELETE'])]
    public function deleteUneSerie(PdoFouDeSerie $pdoFouDeSerie, $id): Response
    {
        if (isset($id)) {
            $pdoFouDeSerie->deleteSerie($id);
            if ($pdoFouDeSerie) {
                return new JsonResponse(['message' => 'Serie supprimée'], 200);
            } else {
                return new JsonResponse(['message' => 'Serie inexistante'], 404);
            }
        } else {
            return new JsonResponse(['message' => 'Serie non supprime'], 404);
        }
    }

    #[Route('/api/series/{id}', name: 'app_api_updateSerie', methods: ['PUT'])]
    public function updateSerieComplete(Request $request, PdoFouDeSerie $pdoFouDeSerie, $id)
    {
        $laserie = $pdoFouDeSerie->getLesSeries($id);
        if ($laserie == false) {
            return new JsonResponse(['message' => 'Serie inexistante'], response::HTTP_NOT_FOUND);
        }
        $content = $request->getContent();
        if (!empty($content)) {
            $laserie = json_decode($content, true);
            $laSeriemodif = $pdoFouDeSerie->updateSerieComplete($id, $laserie);
            $tabJson =
                [
                    'id' => $laSeriemodif['id'],
                    'titre' => $laSeriemodif['titre'],
                    'resume' => $laSeriemodif['resume'],
                    'duree' => $laSeriemodif['duree'],
                    'premiereDiffusion' => $laSeriemodif['premiereDiffusion'],
                ];
        }
        return new JsonResponse($tabJson, Response::HTTP_OK);
    }
}
    