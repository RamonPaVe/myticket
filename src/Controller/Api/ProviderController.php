<?php

namespace App\Controller\Api;

use App\Entity\Provider;
use App\Form\Type\ProviderFormType;
use App\Repository\ProviderRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class ProviderController extends AbstractFOSRestController{
    /**
     * @Rest\Get(path="/provider")
     * @Rest\View(serializerGroups={"provider"}, serializerEnableMaxDepthChecks=true)
     */
    public function getActions(
        ProviderRepository $providerRepository
    ){
        return $providerRepository->findAll();
    }


     /**
     * @Rest\Post(path="/provider")
     * @Rest\View(serializerGroups={"provider"}, serializerEnableMaxDepthChecks=true)
     */
    public function postActions(
        EntityManagerInterface $em, Request $request
    ){
        $provider=new Provider();
        $form = $this->createForm(ProviderFormType::class, $provider);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($provider);
            $em->flush();
            return $provider;
        }
        return $form;
    }
}