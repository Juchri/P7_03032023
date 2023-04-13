<?php

namespace App\Controller;

use App\Repository\MobileRepository;
use App\Repository\BrandRepository;

use App\Entity\Mobile;
use ContainerX5T2ebW\getJmsSerializer_SerializationContextFactoryService;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use JMS\Serializer\Serializer;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;

class MobileController extends AbstractController
{

    #[Route('/api/mobile-list', name: 'mobiles', methods: ['GET'])]
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

    #[Route('/api/mobiles', name: 'mobile', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour créer un mobile')]
    public function getMobileList(MobileRepository $mobileRepository, SerializerInterface $serializer): JsonResponse
    {
        $mobileList = $mobileRepository->findAll();
        $context = SerializationContext::create()->setGroups(['getMobiles']);
        $jsonMobileList = $serializer->serialize($mobileList, 'json', $context);
        return new JsonResponse($jsonMobileList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/mobiles/{id}', name: 'detailMobile', methods: ['GET'])]
    public function getDetailMobile(Mobile $mobile, SerializerInterface $serializer): JsonResponse 
    {
        $context = SerializationContext::create()->setGroups(['getMobiles']);
        $jsonMobile = $serializer->serialize($mobile, 'json', $context);
        return new JsonResponse($jsonMobile, Response::HTTP_OK, [], true);
    }

    #[Route('/api/mobiles/{id}', name: 'deleteMobile', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour supprimer un mobile')]
    public function deleteMobile(Mobile $mobile, EntityManagerInterface $em, TagAwareCacheInterface $cachePool): JsonResponse 
    {
        $cachePool->invalidateTags(["mobilesCache"]);
        $em->remove($mobile);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

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
        $idBrand = $content['idBrand'] ?? -1;

        $currentMobile->setBrand($brandRepository->find($idBrand));

        $em->persist($currentMobile);
        $em->flush();

        // On vide le cache.
        $cache->invalidateTags(["mobilesCache"]);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}

