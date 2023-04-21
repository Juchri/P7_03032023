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



use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use JMS\Serializer\Serializer;
use JMS\Serializer\SerializationContext;

use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class BrandController extends AbstractController
{
     /**
     * Cette méthode permet de récupérer l'ensemble des marques.
     *
     * @OA\Response(
     *     response=200,
     *     description="Retourne la liste des marques disponibles",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Mobile::class, groups={"getMobiles"}))
     *     )
     * )
     * @OA\Tag(name="Brands")
     *
     * @param ClientRepository $clientRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * */
    #[Route('/api/brands', name: 'brand', methods: ['GET'])]
    public function getBrandList(BrandRepository $brandRepository, SerializerInterface $serializer): JsonResponse
    {
        $brandList = $brandRepository->findAll();
        $jsonBrandList = $serializer->serialize($brandList, 'json', ['groups' => 'getMobiles']);
        return new JsonResponse($jsonBrandList, Response::HTTP_OK, [], true);
    }

     /**
     * Cette méthode permet de récupérer une marque.
     *
     * @OA\Response(
     *     response=200,
     *     description="Retourne les informations d'une marque",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Mobile::class, groups={"getMobiles"}))
     *     )
     * )
     * @OA\Tag(name="Brands")
     *
     * @param ClientRepository $clientRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * */
   #[Route('/api/brands/{id}', name: 'detailBrand', methods: ['GET'])]
   public function getDetailBrand(Brand $brand, SerializerInterface $serializer): JsonResponse
   {
       $jsonBrand = $serializer->serialize($brand, 'json', ['groups' => 'getMobiles']);
       return new JsonResponse($jsonBrand, Response::HTTP_OK, ['accept' => 'json'], true);
   }

    /**
     * Cette méthode permet de supprimer une marque.
     *
     * @OA\Response(
     *     response=200,
     *     description="Supprimer une marque",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Mobile::class, groups={"getMobiles"}))
     *     )
     * )
     * @OA\Tag(name="Brands")
     *
     * @param ClientRepository $clientRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * */
    #[Route('/api/brands/{id}', name: 'deleteBrand', methods: ['DELETE'])]
    public function deleteBrand(Brand $brand, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($brand);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

     /**
     * Cette méthode permet de créer une marque.
     *
     * @OA\Response(
     *     response=200,
     *     description="Ajoute une marque",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Mobile::class, groups={"getMobiles"}))
     *     )
     * )
     * @OA\Tag(name="Brands")
     *
     * @param ClientRepository $clientRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * */
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

    /**
     * Cette méthode permet de modifier une marque.
     *
     * @OA\Response(
     *     response=200,
     *     description="Modifie une marque",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Mobile::class, groups={"getMobiles"}))
     *     )
     * )
     * @OA\Tag(name="Brands")
     *
     * @param ClientRepository $clientRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * */
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

