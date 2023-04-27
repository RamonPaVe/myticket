<?php

namespace App\Controller\Api;

use App\Entity\Level;
use App\Form\Type\LevelFormType;
use App\Repository\LevelRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class LevelController extends AbstractFOSRestController{
    /**
     * @Rest\Get(path="/level")
     * @Rest\View(serializerGroups={"level"}, serializerEnableMaxDepthChecks=true)
     */
    public function getActions(
        LevelRepository $levelRepository
    ){
        return $levelRepository->findAll();
    }


     /**
     * @Rest\Post(path="/level")
     * @Rest\View(serializerGroups={"level"}, serializerEnableMaxDepthChecks=true)
     */
    public function postActions(
        EntityManagerInterface $em, Request $request
    ){
        $level=new Level();
        $form = $this->createForm(LevelFormType::class, $level);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($level);
            $em->flush();
            return $level;
        }
        return $form;
    }
}