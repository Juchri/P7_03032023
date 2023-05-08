<?php

namespace App\Controller;

use App\Repository\MobileRepository;
use App\Repository\BrandRepository;

use App\Entity\Mobile;
use App\Service\VersioningService;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use JMS\Serializer\Serializer;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;

use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;

class MobileController extends AbstractController
{
    /**
     * Cette méthode permet de récupérer l'ensemble des mobiles.
     *
     * @OA\Response(
     *     response=200,
     *     description="Retourne la liste des mobiles",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Mobile::class, groups={"getMobiles"}))
     *     )
     * )
     * @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="La page que l'on veut récupérer",
     *     @OA\Schema(type="int")
     * )
     *
     * @OA\Parameter(
     *     name="limit",
     *     in="query",
     *     description="Le nombre d'éléments que l'on veut récupérer",
     *     @OA\Schema(type="int")
     * )
     * @OA\Tag(name="Mobiles")
     *
     * @param MobileRepository $MobileRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/api/mobiles', name: 'mobiles', methods: ['GET'])]
    public function getAllMobiles(MobileRepository $mobileRepository, SerializerInterface $serializer, Request $request, TagAwareCacheInterface $cache): JsonResponse
    {

        $page = $request->get('page', 1);
        $limit = $request->get('limit', 3);

        $idCache = "getAllMobiles-" . $page . "-" . $limit;

        $jsonMobileList = $cache->get($idCache, function (ItemInterface $item) use ($mobileRepository, $page, $limit, $serializer) {
            $item->tag("mobilesCache");
            $item->expiresAfter(3600); //1 heure
            $mobileList = $mobileRepository->findAllWithPagination($page, $limit);
            $context = SerializationContext::create()->setGroups(['getMobiles']);
            return $serializer->serialize($mobileList, 'json', $context);
        });

        return new JsonResponse($jsonMobileList, Response::HTTP_OK, [], true);
   }


      /**
     * Cette méthode permet de récupérer un mobile en particulier.
     *
     * @OA\Response(
     *     response=200,
     *     description="Récupère un mobile",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Client::class))
     *     )
     * )
     * @OA\Tag(name="Mobiles")
     *
     * @param ClientRepository $clientRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * */
    #[Route('/api/mobiles/{id}', name: 'detailMobile', methods: ['GET'])]
    public function getDetailMobile(Mobile $mobile, SerializerInterface $serializer, VersioningService $versioningService): JsonResponse
    {
        
        $version = $versioningService->getVersion();
        $context = SerializationContext::create()->setGroups(['getMobiles']);
        $context->setVersion($version);
        $jsonMobile = $serializer->serialize($mobile, 'json', $context);
        return new JsonResponse($jsonMobile, Response::HTTP_OK, [], true);
    }


    /**
     * Cette méthode permet de supprimer un mobile.
     *
     * @OA\Response(
     *     response=200,
     *     description="Supprime un mobile",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Client::class))
     *     )
     * )
     * @OA\Tag(name="Mobiles")
     *
     * @param ClientRepository $clientRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * */
    #[Route('/api/mobiles/{id}', name: 'deleteMobile', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour supprimer un mobile')]
    public function deleteMobile(Mobile $mobile, EntityManagerInterface $em, TagAwareCacheInterface $cachePool): JsonResponse 
    {
        $cachePool->invalidateTags(["mobilesCache"]);
        $em->remove($mobile);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }


    /**
     * Cette méthode permet de créer un mobile.
     *
     * @OA\Response(
     *     response=200,
     *     description="Créée un mobile",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Client::class))
     *     )
     * )
     * @OA\Tag(name="Mobiles")
     *
     * @param ClientRepository $clientRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * */
    #[Route('/api/mobiles', name:"createMobile", methods: ['POST'])]
    public function createMobile(Request $request, SerializerInterface $serializer, EntityManagerInterface $em,
    UrlGeneratorInterface $urlGenerator, BrandRepository $brandRepository, ValidatorInterface $validator): JsonResponse
    {

        $mobile = $serializer->deserialize($request->getContent(), Mobile::class, 'json');
        $content = $request->toArray();
        $idBrand = $content['idBrand'] ?? -1;

        $mobile->setBrand($brandRepository->find($idBrand));

        // On vérifie les erreurs
        $errors = $validator->validate($mobile);
        if ($errors->count() > 0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
            //throw new HttpException(JsonResponse::HTTP_BAD_REQUEST, "La requête est invalide");
        }

        $em->persist($mobile);
        $em->flush();

        $context = SerializationContext::create()->setGroups(['getMobiles']);
        $jsonMobile = $serializer->serialize($mobile, 'json', $context);

        $location = $urlGenerator->generate('detailMobile', ['id' => $mobile->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonMobile, Response::HTTP_CREATED, ["Location" => $location], true);
   }


    /**
     * Cette méthode permet de modifier un mobile.
     *
     * @OA\Response(
     *     response=200,
     *     description="Modifie un mobile",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Mobile::class))
     *     )
     * )
     * @OA\Tag(name="Mobiles")
     *
     * @param MobileRepository $mobileRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * */
    #[Route('/api/mobiles/{id}', name:"updateMobile", methods:['PUT'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour éditer un livre')]
    public function updateMobile(Request $request, SerializerInterface $serializer, Mobile $currentMobile, EntityManagerInterface $em, BrandRepository $brandRepository, ValidatorInterface $validator, TagAwareCacheInterface $cache): JsonResponse 
    {
        $newMobile = $serializer->deserialize($request->getContent(), Mobile::class, 'json');
        $currentMobile->setModel($newMobile->getModel());

        // On vérifie les erreurs
        $errors = $validator->validate($currentMobile);
        if ($errors->count() > 0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        $content = $request->toArray();
        $idBrand = $content['idBrand'];

        $currentMobile->setBrand($brandRepository->find($idBrand));

        $em->persist($currentMobile);
        $em->flush();

        // On vide le cache.
        $cache->invalidateTags(["mobilesCache"]);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}

