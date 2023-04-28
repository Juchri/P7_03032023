<?php

namespace App\Controller;

use App\Repository\UserRepository;

use App\Entity\User;
use App\Entity\Mobile;

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
     *        @OA\Items(ref=@Model(type=CUser::class))
     *     )
     * )
     * @OA\Tag(name="Users")
     *
     * @param UserRepository $userRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * */
    #[Route('/api/users', name: 'users', methods: ['GET'])]
    public function getUserList(UserRepository $userRepository, SerializerInterface $serializer, Request $request, TagAwareCacheInterface $cache): JsonResponse
    {
        $idCache = "getUsersList";

        $jsonUserList = $cache->get($idCache, function (ItemInterface $item) use ($userRepository, $serializer) {
            $item->tag("mobilesCache");
            $item->expiresAfter(3600); //1 heure
            $userList = $userRepository->findAll();
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
     * @param UserRepository $userRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * */

   #[Route('/api/users/{id}', name: 'detailUser', methods: ['GET'])]
   public function getDetailUser(User $user, SerializerInterface $serializer): JsonResponse
   {
       $jsonUser = $serializer->serialize($user, 'json');
       return new JsonResponse($jsonUser, Response::HTTP_OK, ['accept' => 'json'], true);
   }

     /**
     * Cette méthode permet de supprimer un compte user
     *
     * @OA\Response(
     *     response=200,
     *     description="Supprime un compte user",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=User::class))
     *     )
     * )
     * @OA\Tag(name="Users")
     *
     * @param UserRepository $userRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * */
    #[Route('/api/users/{id}', name: 'deleteUser', methods: ['DELETE'])]
    public function deleteUser(User $user, EntityManagerInterface $em): JsonResponse
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
     * @param UserRepository $userRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * */
    #[Route('/api/users', name:"createUser", methods: ['POST'])]
    public function createUser(Request $request, SerializerInterface $serializer, EntityManagerInterface $em,
    UrlGeneratorInterface $urlGenerator, UserRepository $userRepository, UserPasswordHasherInterface $hash): JsonResponse
    {

        $content = $request->toArray();
        $password = $content['password'];
        $user = $serializer->deserialize($request->getContent(), User::class, 'json');

        $user->setRoles(["ROLE_CLIENT"]);
        $user->setPassword($hash->hashPassword($user, $password));

        $em->persist($user);
        $em->flush();

        $jsonUser = $serializer->serialize($user, 'json');

        $location = $urlGenerator->generate('detailUser', ['id' => $user->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonUser, Response::HTTP_CREATED, ["Location" => $location], true);


   }

    /**
     * Cette méthode permet de mettre à jour un compte user
     *
     * @OA\Response(
     *     response=200,
     *     description="Modifie un compte user",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=CUser::class))
     *     )
     * )
     * @OA\Tag(name="Users")
     *
     * @param UserRepository $userRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * */
   #[Route('/api/users/{id}', name:"updateUser", methods:['PUT'])]

    public function updateUser(Request $request, SerializerInterface $serializer, User $currentUser, EntityManagerInterface $em, UserRepository $userRepository): JsonResponse 
    {
        $updatedUser = $serializer->deserialize($request->getContent(),
                User::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $currentUser]);
        $content = $request->toArray();
        $idUser = $content['idUser'] ?? -1;
        $updatedUser->setUser($userRepository->find($idUsert));

        $em->persist($updatedUser);
        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
   }
}