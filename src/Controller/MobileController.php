<?php

namespace App\Controller;

use App\Repository\MobileRepository;
use App\Repository\BrandRepository;

use App\Entity\Mobile;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MobileController extends AbstractController
{
    #[Route('/api/mobiles', name: 'mobile', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour créer un livre')]
    public function getMobileList(MobileRepository $mobileRepository, SerializerInterface $serializer): JsonResponse
    {
        $mobileList = $mobileRepository->findAll();
        $jsonMobileList = $serializer->serialize($mobileList, 'json', ['groups' => 'getMobiles']);
        return new JsonResponse($jsonMobileList, Response::HTTP_OK, [], true);
    }

   #[Route('/api/mobiles/{id}', name: 'detailMobile', methods: ['GET'])]
   public function getDetailMobile(Mobile $mobile, SerializerInterface $serializer): JsonResponse
   {
       $jsonMobile = $serializer->serialize($mobile, 'json', ['groups' => 'getMobiles']);
       return new JsonResponse($jsonMobile, Response::HTTP_OK, ['accept' => 'json'], true);
   }

    #[Route('/api/mobiles/{id}', name: 'deleteMobile', methods: ['DELETE'])]
    public function deleteMobile(Mobile $mobile, EntityManagerInterface $em): JsonResponse
    {
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

        $jsonMobile = $serializer->serialize($mobile, 'json', ['groups' => 'getMobiles']);

        $location = $urlGenerator->generate('detailMobile', ['id' => $mobile->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonMobile, Response::HTTP_CREATED, ["Location" => $location], true);
   }

   #[Route('/api/mobiles/{id}', name:"updateMobile", methods:['PUT'])]

    public function updateMobile(Request $request, SerializerInterface $serializer, Mobile $currentMobile, EntityManagerInterface $em, BrandRepository $brandRepository): JsonResponse 
    {
        $updatedMobile = $serializer->deserialize($request->getContent(),
                Mobile::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $currentMobile]);
        $content = $request->toArray();
        $idBrand = $content['idBrand'] ?? -1;
        $updatedMobile->setBrand($brandRepository->find($idBrand));

        $em->persist($updatedMobile);
        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
   }
}

