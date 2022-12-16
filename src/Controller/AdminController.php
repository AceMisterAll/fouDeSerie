<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/serie/all', name: 'app_admin_listSeries')]
    public function suppSerie(ManagerRegistry $doctrine): Response
    {
        $Repository = $doctrine->getRepository(Serie::class);
        $lesSeries = $Repository->findAll();
        dump($lesSeries);
        return $this->render('admin/listSeries.html.twig', [
            'lesSeries' => $lesSeries,
        ]);
    }
    
    #[Route('/admin/serie/{id}', name: 'app_admin_suppSerie', methods: 'DELETE')]
    public function suppSerieId($id,Request $request, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $repository = $em->getRepository(Serie::class);
        $serie=$repository->find($id);
        if ($this->isCsrfTokenValid('delete_serie', $request->get('token')))
        {
            $em->remove($serie);
            $em->flush();
        }

        return $this->redirectToRoute('app_admin_listSeries');
    }

    #[Route('/admin/serie', name: 'app_admin_addSerie')]
    public function addSerie(Request $request, ManagerRegistry $Doctrine): Response
    {
        $serie = new Serie();
        dump($serie);
        $form=$this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $Doctrine->getManager();
            $entityManager->persist($serie);
            $entityManager->flush();
            return $this->redirectToRoute('app_series');
        }
        dump($serie);
        return $this->render('admin/addSerie.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/serie/{id}', name: 'app_admin_editSerie')]
    public function editSerie(Request $request, ManagerRegistry $doctrine, $id): Response
    {
        /*$form=$this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $Doctrine->getManager();
            $entityManager->persist($serie);
            $entityManager->flush();
            return $this->redirectToRoute('app_series');
        }*/

        $repository = $doctrine->getRepository(Serie::class);
        $laSerie = $repository->find($id);
        $form=$this->createForm(SerieType::class, $laSerie,['method' => 'PUT']);

        $form->handleRequest($request);// recup les données du form
        if($form->isSubmitted() && $form->isValid())
        {
            $EntityManager=$doctrine->getManager();
            $EntityManager->flush(); // ajoute dans la bdd
            return $this->redirectToRoute('app_series'); //redirige sur la page des series
        }
        return $this->render('admin/editeSerie.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}