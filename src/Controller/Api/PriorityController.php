<?php

namespace App\Controller\Api;

use App\Entity\Priority;
use App\Form\Type\PriorityFormType;
use App\Repository\PriorityRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class PriorityController extends AbstractFOSRestController{
    /**
     * @Rest\Get(path="/priority")
     * @Rest\View(serializerGroups={"priority"}, serializerEnableMaxDepthChecks=true)
     */
    public function getActions(
        PriorityRepository $priorityRepository
    ){
        return $priorityRepository->findAll();
    }


     /**
     * @Rest\Post(path="/priority")
     * @Rest\View(serializerGroups={"priority"}, serializerEnableMaxDepthChecks=true)
     */
    public function postActions(
        EntityManagerInterface $em, Request $request
    ){
        $priority=new Priority();
        $form = $this->createForm(PriorityFormType::class, $priority);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($priority);
            $em->flush();
            return $priority;
        }
        return $form;
    }
}