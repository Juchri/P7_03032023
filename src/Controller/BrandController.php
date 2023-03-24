<?php

namespace App\Controller;

use App\Repository\BrandRepository;

use App\Entity\Brand;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BrandController extends AbstractController
{
    #[Route('/api/brands', name: 'brand', methods: ['GET'])]
    public function getBrandList(BrandRepository $brandRepository, SerializerInterface $serializer): JsonResponse
    {
        $brandList = $brandRepository->findAll();
        $jsonBrandList = $serializer->serialize($brandList, 'json', ['groups' => 'getMobiles']);
        return new JsonResponse($jsonBrandList, Response::HTTP_OK, [], true);
    }

   #[Route('/api/brands/{id}', name: 'detailBrand', methods: ['GET'])]
   public function getDetailBrand(Brand $brand, SerializerInterface $serializer): JsonResponse
   {
       $jsonBrand = $serializer->serialize($brand, 'json', ['groups' => 'getMobiles']);
       return new JsonResponse($jsonBrand, Response::HTTP_OK, ['accept' => 'json'], true);
   }

    #[Route('/api/brands/{id}', name: 'deleteBrand', methods: ['DELETE'])]
    public function deleteBrand(Brand $brand, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($brand);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/brands', name:"createBrand", methods: ['POST'])]
    public function createBrand(Request $request, SerializerInterface $serializer, EntityManagerInterface $em,
    UrlGeneratorInterface $urlGenerator, BrandRepository $brandRepository): JsonResponse
    {

        $brand = $serializer->deserialize($request->getContent(), Brand::class, 'json');

        $content = $request->toArray();

        $em->persist($brand);
        $em->flush();

        $jsonBrand = $serializer->serialize($brand, 'json');

        $location = $urlGenerator->generate('detailBrand', ['id' => $brand->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonBrand, Response::HTTP_CREATED, ["Location" => $location], true);
   }

   #[Route('/api/brands/{id}', name:"updateBrand", methods:['PUT'])]

    public function updateBrand(Request $request, SerializerInterface $serializer, Brand $currentBrand, EntityManagerInterface $em, BrandRepository $brandRepository): JsonResponse 
    {
        $updatedBrand = $serializer->deserialize($request->getContent(),
                Brand::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $currentBrand]);
        $content = $request->toArray();
        $idBrand = $content['idBrand'] ?? -1;
        $updatedBrand->setBrand($brandRepository->find($idBrand));

        $em->persist($updatedBrand);
        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
   }
}

