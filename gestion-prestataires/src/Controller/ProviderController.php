<?php
// src/Controller/ProviderController.php

namespace App\Controller;

use App\Entity\Provider; // Assurez-vous que le namespace correspond à votre entité Provider
use App\Repository\ProviderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProviderController extends AbstractController
{
    private $providerRepository;
    private $entityManager;

    public function __construct(ProviderRepository $providerRepository, EntityManagerInterface $entityManager)
    {
        $this->providerRepository = $providerRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/providers", methods={"GET"})
     */
    public function getAllProviders(): Response
    {
        $providers = $this->providerRepository->findAll();
        return $this->json($providers);
    }

    /**
     * @Route("/providers", methods={"POST"})
     */
    public function createProvider(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $provider = new Provider();
        // Remplir les propriétés de l'entité avec les données
        // $provider->setName($data['name']);
        // Ajoutez d'autres propriétés ici

        $this->entityManager->persist($provider);
        $this->entityManager->flush();

        return $this->json($provider, Response::HTTP_CREATED);
    }

    /**
     * @Route("/providers/{id}", methods={"GET"})
     */
    public function getProvider(int $id): Response
    {
        $provider = $this->providerRepository->find($id);
        if (!$provider) {
            throw $this->createNotFoundException('Provider not found');
        }
        return $this->json($provider);
    }

    /**
     * @Route("/providers/{id}", methods={"PUT"})
     */
    public function updateProvider(Request $request, int $id): Response
    {
        $data = json_decode($request->getContent(), true);
        $provider = $this->providerRepository->find($id);
        if (!$provider) {
            throw $this->createNotFoundException('Provider not found');
        }

        // Mettre à jour les propriétés de l'entité avec les données
        // $provider->setName($data['name']);
        // Ajoutez d'autres propriétés ici

        $this->entityManager->flush();

        return $this->json($provider);
    }

    /**
     * @Route("/providers/{id}", methods={"DELETE"})
     */
    public function deleteProvider(int $id): Response
    {
        $provider = $this->providerRepository->find($id);
        if (!$provider) {
            throw $this->createNotFoundException('Provider not found');
        }

        $this->entityManager->remove($provider);
        $this->entityManager->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
