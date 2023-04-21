<?php

namespace App\Controller;

use App\Repository\ClientRepository;

use App\Entity\Client;
use App\Entity\Mobile;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use JMS\Serializer\Serializer;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;

use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientController extends AbstractController
{
    /**
     * Cette méthode permet de récupérer l'ensemble des clients.
     *
     * @OA\Response(
     *     response=200,
     *     description="Retourne la liste des clients",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Client::class))
     *     )
     * )
     * @OA\Tag(name="Clients")
     *
     * @param ClientRepository $clientRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * */
    #[Route('/api/clients', name: 'client', methods: ['GET'])]
    public function getClientList(ClientRepository $clientRepository, SerializerInterface $serializer, Request $request, TagAwareCacheInterface $cache): JsonResponse
    {
        $idCache = "getClientList";

        $jsonClientList = $cache->get($idCache, function (ItemInterface $item) use ($clientRepository, $serializer) {
            $item->tag("mobilesCache");
            $item->expiresAfter(3600); //1 heure
            $clientList = $clientRepository->findAll();
            $context = SerializationContext::create();
            return $serializer->serialize($clientList, 'json', $context);
        });

        return new JsonResponse($jsonClientList, Response::HTTP_OK, [], true);
    }

     /**
     * Cette méthode permet d'afficher un client en particulierr.
     *
     * @OA\Response(
     *     response=200,
     *     description="Retourne un client spécifique",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Client::class))
     *     )
     * )
     * @OA\Tag(name="Clients")
     *
     * @param ClientRepository $clientRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * */

   #[Route('/api/clients/{id}', name: 'detailClient', methods: ['GET'])]
   public function getDetailClient(Client $client, SerializerInterface $serializer): JsonResponse
   {
       $jsonClient = $serializer->serialize($client, 'json');
       return new JsonResponse($jsonClient, Response::HTTP_OK, ['accept' => 'json'], true);
   }

     /**
     * Cette méthode permet de supprimer un compte client
     *
     * @OA\Response(
     *     response=200,
     *     description="Supprime un compte client",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Client::class))
     *     )
     * )
     * @OA\Tag(name="Clients")
     *
     * @param ClientRepository $clientRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * */
    #[Route('/api/clients/{id}', name: 'deleteClient', methods: ['DELETE'])]
    public function deleteClient(Client $client, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($client);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Cette méthode permet de créer un compte client
     *
     * @OA\Response(
     *     response=200,
     *     description="Crée un compte client",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Client::class))
     *     )
     * )
     * @OA\Tag(name="Clients")
     *
     * @param ClientRepository $clientRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * */
    #[Route('/api/clients', name:"createClient", methods: ['POST'])]
    public function createClient(Request $request, SerializerInterface $serializer, EntityManagerInterface $em,
    UrlGeneratorInterface $urlGenerator, ClientRepository $clientRepository): JsonResponse
    {

        $client = $serializer->deserialize($request->getContent(), Client::class, 'json');
        $client->setRoles(["ROLE_CLIENT"]);

        $client->setPassword($this->clientPasswordHasher->hashPassword($client, "password"));

        $content = $request->toArray();

        $em->persist($client);
        $em->flush();

        $jsonClient = $serializer->serialize($client, 'json');

        $location = $urlGenerator->generate('detailClient', ['id' => $client->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonClient, Response::HTTP_CREATED, ["Location" => $location], true);
   }

    /**
     * Cette méthode permet de mettre à jour un compte client
     *
     * @OA\Response(
     *     response=200,
     *     description="Modifie un compte client",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Client::class))
     *     )
     * )
     * @OA\Tag(name="Clients")
     *
     * @param ClientRepository $clientRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * */
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

