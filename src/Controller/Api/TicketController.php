<?php

namespace App\Controller\Api;

use App\Entity\Ticket;
use App\Form\Type\TicketFormType;
use App\Repository\TicketRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class TicketController extends AbstractFOSRestController{
    /**
     * @Rest\Get(path="/ticket")
     * @Rest\View(serializerGroups={"ticket"}, serializerEnableMaxDepthChecks=true)
     */
    public function getActions(
        TicketRepository $ticketRepository
    ){
        return $ticketRepository->findAll();
    }


     /**
     * @Rest\Post(path="/ticket")
     * @Rest\View(serializerGroups={"ticket"}, serializerEnableMaxDepthChecks=true)
     */
    public function postActions(
        EntityManagerInterface $em, Request $request
    ){
        $ticket=new Ticket();
        $form = $this->createForm(TicketFormType::class, $ticket);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($ticket);
            $em->flush();
            return $ticket;
        }
        return $form;
    }
}