<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Form\Type\UserFormType;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class UserController extends AbstractFOSRestController{
    /**
     * @Rest\Get(path="/user")
     * @Rest\View(serializerGroups={"user"}, serializerEnableMaxDepthChecks=true)
     */
    public function getActions(
        UserRepository $userRepository
    ){
        return $userRepository->findAll();
    }


     /**
     * @Rest\Post(path="/user")
     * @Rest\View(serializerGroups={"user"}, serializerEnableMaxDepthChecks=true)
     */
    public function postActions(
        EntityManagerInterface $em, Request $request
    ){
        $user=new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($user);
            $em->flush();
            return $user;
        }
        return $form;
    }
}