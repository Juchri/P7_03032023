<?php

namespace App\Controller;

use App\Repository\MobileRepository;
use App\Entity\Mobile;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MobileController extends AbstractController
{
    #[Route('/api/mobiles', name: 'mobile', methods: ['GET'])]
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
}

