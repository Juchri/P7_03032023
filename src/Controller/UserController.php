<?php

namespace App\Controller;

use App\Repository\UserRepository;

use App\Entity\User;
use App\Entity\Mobile;
use App\Repository\MobileRepository;
use Doctrine\Persistence\ObjectManager;

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

class UserController extends AbstractController
{
    /**
     * Cette méthode permet de récupérer l'ensemble des users.
     *
     * @OA\Response(
     *     response=200,
     *     description="Retourne la liste des users",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=User::class))
     *     )
     * )
     * @OA\Tag(name="Users")
     *
     * @param UserRepository $userRepository
     * @param SerializerInterface $serializer
     * @param TagAwareCacheInterface $cache
     * @return JsonResponse
     * */
    #[Route('/api/users', name: 'usersList', methods: ['GET'])]
    public function getUserList(UserRepository $userRepository, SerializerInterface $serializer, TagAwareCacheInterface $cache): JsonResponse
    {

        $idCache = "getUsersList";
        $jsonUserList = $cache->get($idCache, function (ItemInterface $item) use ($userRepository, $serializer) {
            $item->tag("mobilesCache");
            $item->expiresAfter(3600); //1 heure
            $userList = $userRepository->findUsersByRole('ROLE_USER');
            $context = SerializationContext::create();
            return $serializer->serialize($userList, 'json', $context);
        });

        return new JsonResponse($jsonUserList, Response::HTTP_OK, [], true);
    }

     /**
     * Cette méthode permet d'afficher un user en particulierr.
     *
     * @OA\Response(
     *     response=200,
     *     description="Retourne un user spécifique",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=User::class))
     *     )
     * )
     * @OA\Tag(name="Users")
     *
     * @param User $user
     * @param SerializerInterface $serializer
     * @return JsonResponse
     * */


   #[Route('/api/clients/{id}', name: 'detailUser', methods: ['GET'])]
   public function getDetailClient(User $user, SerializerInterface $serializer): JsonResponse
   {
        $jsonUser = $serializer->serialize($user, 'json');
        return new JsonResponse($jsonUser, Response::HTTP_OK, ['accept' => 'json'], true);
   }

     /**
     * Cette méthode permet de supprimer un compte user
     *
     * @OA\Response(
     *     response=200,
     *     description="Supprime un compte user uniquement",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=User::class))
     *     )
     * )
     * @OA\Tag(name="Users")
     *
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return JsonResponse
     * */
    #[Route('/api/users/{id}', name: 'deleteUser', methods: ['DELETE'])]
    public function deleteUser(User $user, EntityManagerInterface $em): JsonResponse
    {
        if($user->getRoles() == 'ROLE_USER') {
            $em->remove($user);
            $em->flush();
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }else{
            echo 'Cet utilisateur n\'est pas un simple user. Allez à la route /api/users/clients/{id} pour le supprimer';
        }
    }


    /**
     * Cette méthode permet de mettre à jour un compte d'utilisateur
     *
     * @OA\Response(
     *     response=200,
     *     description="Modifie un utilisateur",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=User::class))
     *     )
     * )
     * @OA\Tag(name="Users")
     *
     * @param User $currentUser
     * @param UserPasswordHasherInterface $hash
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * */
    #[Route('/api/users/{id}', name:"updateUser", methods:['PUT'])]
    public function updateUser(Request $request, UserPasswordHasherInterface $hash, SerializerInterface $serializer, User $currentUser, EntityManagerInterface $em, ValidatorInterface $validator, TagAwareCacheInterface $cache): JsonResponse 
    {
        $newUser = $serializer->deserialize($request->getContent(), User::class, 'json');
        $currentUser->setEmail($newUser->getEmail());
        $currentUser->setFirstName($newUser->getFirstName());
        $currentUser->setName($newUser->getName());

        $content = $request->toArray();
        $password = $content['password'];
        $currentUser->setPassword($hash->hashPassword($currentUser, $password));

        // On vérifie les erreurs
        $errors = $validator->validate($currentUser);
        if ($errors->count() > 0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        $em->persist($currentUser);
        $em->flush();

        // On vide le cache.
        $cache->invalidateTags(["usersCache"]);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }


    /**
     * Cette méthode permet de créer un compte client, en lien avec un utilisateur
     *
     * @OA\Response(
     *     response=200,
     *     description="Ajoute un client à un utilisateur. <br> <br> Si l'utilisateur existe déjà, ne renseigner que l'id du client :  'client_id': '{id}' dans le raw (JSON). <br><br> Sinon, crez l'utilisateur avec les données : <br> 'first_name', <br>'name', <br>'email', <br>'password'",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=User::class))
     *     )
     * )
     * @OA\Tag(name="Users")
     *
     * @param User $user
     * @param Request $request
     * @param UserPasswordHasherInterface $hash
     * @param EntityManagerInterface $em
     * @return JsonResponse
     * */
    #[Route('/api/users/add-client/{id}', name:"addClient", methods:['POST'])]
    public function addClient(Request $request, UserPasswordHasherInterface $hash, User $currentUser, EntityManagerInterface $em): JsonResponse 
    {
        $content = $request->toArray();

        if (isset($content['email'])) {
            $first_name = $content['first_name'];
            $name = $content['name'];
            $email = $content['email'];
            $password = $content['password'];

            $client = new User();
            $client->setEmail($email);
            $client->setFirstName($first_name);
            $client->setName($name);
            $client->setRoles(["ROLE_CLIENT"]);
            $client->setPassword($hash->hashPassword($client, $password));
        } elseif (isset($content['client_id'])) {
            $client_id = $content['client_id'];
            $userRepository = $em->getRepository(User::class);
            $client = $userRepository->find($client_id);
        }

        $currentUser->addClient($client);

        $em->persist($client);
        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }


    /**
     * Cette méthode permet d'ajouter un mobile à un client
     *
     * @OA\Response(
     *     response=200,
     *     description="Modifie un utilisateur",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=User::class))
     *     )
     * )
     * @OA\Tag(name="Users")
     *
     * @param User $currentUser
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return JsonResponse
     * */
    #[Route('/api/users/add-mobile/{id}', name:"linkUser", methods:['POST'])]
    public function addMobile(Request $request, User $currentUser, EntityManagerInterface $em): JsonResponse
    {
        $content = $request->toArray();
        $id_mobile = $content['mobile'];
        $mobileRepository = $em->getRepository(Mobile::class);
        $mobile = $mobileRepository->find($id_mobile);

        $currentUser->addMobile($mobile);
        $em->persist($currentUser);
        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * Cette méthode permet de récupérer l'ensemble des clients.
     *
     * @OA\Response(
     *     response=200,
     *     description="Retourne ",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=User::class))
     *     )
     * )
     * @OA\Tag(name="Clients")
     *
     * @param UserRepository $userRepository
     * @param SerializerInterface $serializer
     * @param TagAwareCacheInterface $cache
     * @return JsonResponse
     * */
    #[Route('/api/clients', name: 'users', methods: ['GET'])]
    public function getClientList(UserRepository $userRepository, SerializerInterface $serializer, TagAwareCacheInterface $cache): JsonResponse
    {
        $idCache = "getUsersList";

        $jsonUserList = $cache->get($idCache, function (ItemInterface $item) use ($userRepository, $serializer) {
            $item->tag("mobilesCache");
            $item->expiresAfter(3600); //1 heure
            $userList = $userRepository->findUsersByRole('ROLE_CLIENT');
            $context = SerializationContext::create();

            return $serializer->serialize($userList, 'json', $context);
        });

        return new JsonResponse($jsonUserList, Response::HTTP_OK, [], true);
    }

     /**
     * Cette méthode permet d'afficher un user en particulierr.
     *
     * @OA\Response(
     *     response=200,
     *     description="Retourne un user spécifique",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=User::class))
     *     )
     * )
     * @OA\Tag(name="Users")
     *
     * @param User $user
     * @param SerializerInterface $serializer
     * @return JsonResponse
     * */

   #[Route('/api/users/{id}', name: 'detailUser', methods: ['GET'])]
   public function getDetailUser(User $user, SerializerInterface $serializer): JsonResponse
   {
       $jsonUser = $serializer->serialize($user, 'json');
       return new JsonResponse($jsonUser, Response::HTTP_OK, ['accept' => 'json'], true);
   }

     /**
     * Cette méthode permet de supprimer un compte client
     *
     * @OA\Response(
     *     response=200,
     *     description="Supprime n'importe quel compte (dont compte client)",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=User::class))
     *     )
     * )
     * @OA\Tag(name="Clients")
     *
     * @param User $user
     * @param EntityManagerInterface $em
     * @return JsonResponse
     * */
    #[Route('/api/clients/{id}', name: 'deleteClient', methods: ['DELETE'])]
    public function deleteClient (User $user, EntityManagerInterface $em): JsonResponse
    {
            $em->remove($user);
            $em->flush();
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Cette méthode permet de créer un compte user
     *
     * @OA\Response(
     *     response=200,
     *     description="Crée un compte user",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=User::class))
     *     )
     * )
     * @OA\Tag(name="Users")
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface $serializer
     * @param Request $request
     * @param UrlGeneratorInterface $urlGenerator
     * @param UserPasswordHasherInterface $hash
     * @return JsonResponse
     * */
    #[Route('/api/users', name:"createUser", methods: ['POST'])]
    public function createUser(Request $request, SerializerInterface $serializer, EntityManagerInterface $em,
    UrlGeneratorInterface $urlGenerator, UserPasswordHasherInterface $hash): JsonResponse
    {

        $content = $request->toArray();
        $password = $content['password'];
        $user = $serializer->deserialize($request->getContent(), User::class, 'json');

        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($hash->hashPassword($user, $password));

        $em->persist($user);
        $em->flush();

        $jsonUser = $serializer->serialize($user, 'json');

        $location = $urlGenerator->generate('detailUser', ['id' => $user->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonUser, Response::HTTP_CREATED, ["Location" => $location], true);


   }



}