<?php

namespace App\Controller;

use App\Entity\Serie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/news', name: 'app_news')]
    public function news(): Response
    {
        return $this->render('home/news.html.twig',['nbNews'=>4]);
    }

    #[Route('/testEntity', name: 'app_testEntity')]
    public function testEntity(ManagerRegistry $doctrine): Response
    {
        // Instanciation d'un objet : création d'une entité
        $Serie = new Serie();
        $Serie->setTitre('Naruto');
        $Serie->setResume("Naruto est un shōnen manga écrit et dessiné par Masashi Kishimoto. Naruto a été prépublié dans l'hebdomadaire Weekly Shōnen Jump de l'éditeur Shūeisha entre septembre 1999 et novembre 2014. La série a été compilée en 72 tomes. La version française du manga est publiée par Kana entre mars 2002 et novembre 2016.");
        $Serie->setDuree(new \DateTime('12:56:15'));
        $Serie->setPremiereDiffusion(new \DateTime('1999-09-21'));
        $Serie->setImage('https://lc.cx/uMopid');

        $entityManager = $doctrine->getManager();
        // On persiste l'entité
        $entityManager->persist($Serie);
        // Exécution de la requête
        $entityManager->flush();
        return $this->render('home/testEntity.html.twig',
        [
            'Serie' => $Serie
        ]);
    }
}
