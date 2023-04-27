<?php

namespace App\Controller\Api;

use App\Entity\State;
use App\Form\Type\StateFormType;
use App\Repository\StateRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class StateController extends AbstractFOSRestController{
    /**
     * @Rest\Get(path="/state")
     * @Rest\View(serializerGroups={"state"}, serializerEnableMaxDepthChecks=true)
     */
    public function getActions(
        StateRepository $stateRepository
    ){
        return $stateRepository->findAll();
    }


     /**
     * @Rest\Post(path="/state")
     * @Rest\View(serializerGroups={"state"}, serializerEnableMaxDepthChecks=true)
     */
    public function postActions(
        EntityManagerInterface $em, Request $request
    ){
        $state=new State();
        $form = $this->createForm(StateFormType::class, $state);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($state);
            $em->flush();
            return $state;
        }
        return $form;
    }
}