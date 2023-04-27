<?php

namespace App\Controller\Api;

use App\Entity\TicketType;
use App\Form\Type\TicketTypeFormType;
use App\Repository\TicketTypeRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class TicketTypeController extends AbstractFOSRestController{
    /**
     * @Rest\Get(path="/ticketType")
     * @Rest\View(serializerGroups={"ticketType"}, serializerEnableMaxDepthChecks=true)
     */
    public function getActions(
        TicketTypeRepository $ticketTypeRepository
    ){
        return $ticketTypeRepository->findAll();
    }


     /**
     * @Rest\Post(path="/ticketType")
     * @Rest\View(serializerGroups={"ticketType"}, serializerEnableMaxDepthChecks=true)
     */
    public function postActions(
        EntityManagerInterface $em, Request $request
    ){
        $ticketType=new TicketType();
        $form = $this->createForm(TicketTypeFormType::class, $ticketType);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($ticketType);
            $em->flush();
            return $ticketType;
        }
        return $form;
    }
}