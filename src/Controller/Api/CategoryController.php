<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Form\Type\CategoryFormType;
use App\Repository\CategoryRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class CategoryController extends AbstractFOSRestController{
    /**
     * @Rest\Get(path="/category")
     * @Rest\View(serializerGroups={"category"}, serializerEnableMaxDepthChecks=true)
     */
    public function getActions(
        CategoryRepository $categoryRepository
    ){
        return $categoryRepository->findAll();
    }


     /**
     * @Rest\Post(path="/category")
     * @Rest\View(serializerGroups={"category"}, serializerEnableMaxDepthChecks=true)
     */
    public function postActions(
        EntityManagerInterface $em, Request $request
    ){
        $category=new Category();
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($category);
            $em->flush();
            return $category;
        }
        return $form;
    }
}