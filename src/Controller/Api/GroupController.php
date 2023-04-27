<?php

namespace App\Controller\Api;

use App\Entity\Group;
use App\Form\Type\GroupFormType;
use App\Repository\GroupRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class GroupController extends AbstractFOSRestController{
    /**
     * @Rest\Get(path="/group")
     * @Rest\View(serializerGroups={"group"}, serializerEnableMaxDepthChecks=true)
     */
    public function getActions(
        GroupRepository $groupRepository
    ){
        return $groupRepository->findAll();
    }


     /**
     * @Rest\Post(path="/group")
     * @Rest\View(serializerGroups={"group"}, serializerEnableMaxDepthChecks=true)
     */
    public function postActions(
        EntityManagerInterface $em, Request $request
    ){
        $group=new Group();
        $form = $this->createForm(GroupFormType::class, $group);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($group);
            $em->flush();
            return $group;
        }
        return $form;
    }
}