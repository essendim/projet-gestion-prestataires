<?php
// src/Controller/ServiceController.php

namespace App\Controller;

use App\Entity\Service; // Assurez-vous que le namespace correspond à votre entité Service
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    private $serviceRepository;
    private $entityManager;

    public function __construct(ServiceRepository $serviceRepository, EntityManagerInterface $entityManager)
    {
        $this->serviceRepository = $serviceRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/services", methods={"GET"})
     */
    public function getAllServices(): Response
    {
        $services = $this->serviceRepository->findAll();
        return $this->json($services);
    }

    /**
     * @Route("/services", methods={"POST"})
     */
    public function createService(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $service = new Service();
        // Remplir les propriétés de l'entité avec les données
        // $service->setName($data['name']);
        // Ajoutez d'autres propriétés ici

        $this->entityManager->persist($service);
        $this->entityManager->flush();

        return $this->json($service, Response::HTTP_CREATED);
    }

    /**
     * @Route("/services/{id}", methods={"GET"})
     */
    public function getService(int $id): Response
    {
        $service = $this->serviceRepository->find($id);
        if (!$service) {
            throw $this->createNotFoundException('Service not found');
        }
        return $this->json($service);
    }

    /**
     * @Route("/services/{id}", methods={"PUT"})
     */
    public function updateService(Request $request, int $id): Response
    {
        $data = json_decode($request->getContent(), true);
        $service = $this->serviceRepository->find($id);
        if (!$service) {
            throw $this->createNotFoundException('Service not found');
        }

        // Mettre à jour les propriétés de l'entité avec les données
        // $service->setName($data['name']);
        // Ajoutez d'autres propriétés ici

        $this->entityManager->flush();

        return $this->json($service);
    }

    /**
     * @Route("/services/{id}", methods={"DELETE"})
     */
    public function deleteService(int $id): Response
    {
        $service = $this->serviceRepository->find($id);
        if (!$service) {
            throw $this->createNotFoundException('Service not found');
        }

        $this->entityManager->remove($service);
        $this->entityManager->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
