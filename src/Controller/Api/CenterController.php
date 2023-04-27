<?php

namespace App\Controller\Api;

use App\Entity\Center;
use App\Form\Type\CenterFormType;
use App\Repository\CenterRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class CenterController extends AbstractFOSRestController{
    /**
     * @Rest\Get(path="/center")
     * @Rest\View(serializerGroups={"center"}, serializerEnableMaxDepthChecks=true)
     */
    public function getActions(
        CenterRepository $centerRepository
    ){
        return $centerRepository->findAll();
    }


     /**
     * @Rest\Post(path="/center")
     * @Rest\View(serializerGroups={"center"}, serializerEnableMaxDepthChecks=true)
     */
    public function postActions(
        EntityManagerInterface $em, Request $request
    ){
        $center=new Center();
        $form = $this->createForm(CenterFormType::class, $center);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($center);
            $em->flush();
            return $center;
        }
        return $form;
    }
}