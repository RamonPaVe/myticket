<?php

namespace App\Controller\Api;

use App\Entity\Notes;
use App\Form\Type\NotesFormType;
use App\Repository\NotesRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class NotesController extends AbstractFOSRestController{
    /**
     * @Rest\Get(path="/notes")
     * @Rest\View(serializerGroups={"notes"}, serializerEnableMaxDepthChecks=true)
     */
    public function getActions(
        NotesRepository $notesRepository
    ){
        return $notesRepository->findAll();
    }


     /**
     * @Rest\Post(path="/notes")
     * @Rest\View(serializerGroups={"notes"}, serializerEnableMaxDepthChecks=true)
     */
    public function postActions(
        EntityManagerInterface $em, Request $request
    ){
        $notes=new Notes();
        $form = $this->createForm(NotesFormType::class, $notes);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($notes);
            $em->flush();
            return $notes;
        }
        return $form;
    }
}