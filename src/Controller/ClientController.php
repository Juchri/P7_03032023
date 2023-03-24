<?php

namespace App\Controller;

use App\Repository\ClientRepository;

use App\Entity\Client;
use App\Entity\Mobile;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    #[Route('/api/clients', name: 'client', methods: ['GET'])]
    public function getClientList(ClientRepository $clientRepository, SerializerInterface $serializer): JsonResponse
    {
        $clientList = $clientRepository->findAll();
        $jsonClientList = $serializer->serialize($clientList);
        return new JsonResponse($jsonClientList, Response::HTTP_OK, [], true);
    }

   #[Route('/api/clients/{id}', name: 'detailClient', methods: ['GET'])]
   public function getDetailClient(Client $client, SerializerInterface $serializer): JsonResponse
   {
       $jsonClient = $serializer->serialize($client, 'json');
       return new JsonResponse($jsonClient, Response::HTTP_OK, ['accept' => 'json'], true);
   }

    #[Route('/api/clients/{id}', name: 'deleteClient', methods: ['DELETE'])]
    public function deleteClient(Client $client, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($client);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/clients', name:"createClient", methods: ['POST'])]
    public function createClient(Request $request, SerializerInterface $serializer, EntityManagerInterface $em,
    UrlGeneratorInterface $urlGenerator, ClientRepository $clientRepository): JsonResponse
    {

        $client = $serializer->deserialize($request->getContent(), Client::class, 'json');
        $content = $request->toArray();

        $em->persist($client);
        $em->flush();

        $jsonClient = $serializer->serialize($client, 'json');

        $location = $urlGenerator->generate('detailClient', ['id' => $client->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonClient, Response::HTTP_CREATED, ["Location" => $location], true);
   }

   #[Route('/api/clients/{id}', name:"updateClient", methods:['PUT'])]

    public function updateClient(Request $request, SerializerInterface $serializer, Client $currentClient, EntityManagerInterface $em, ClientRepository $clientRepository): JsonResponse 
    {
        $updatedClient = $serializer->deserialize($request->getContent(),
                Client::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $currentClient]);
        $content = $request->toArray();
        $idClient = $content['idClient'] ?? -1;
        $updatedClient->setClient($clientRepository->find($idClient));

        $em->persist($updatedClient);
        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
   }
}

