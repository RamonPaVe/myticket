<?php

namespace App\Controller\Api;

use App\Entity\Subcategory;
use App\Form\Type\SubcategoryFormType;
use App\Repository\SubcategoryRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class SubcategoryController extends AbstractFOSRestController{
    /**
     * @Rest\Get(path="/subcategory")
     * @Rest\View(serializerGroups={"subcategory"}, serializerEnableMaxDepthChecks=true)
     */
    public function getActions(
        SubcategoryRepository $subcategoryRepository
    ){
        return $subcategoryRepository->findAll();
    }


     /**
     * @Rest\Post(path="/subcategory")
     * @Rest\View(serializerGroups={"subcategory"}, serializerEnableMaxDepthChecks=true)
     */
    public function postActions(
        EntityManagerInterface $em, Request $request
    ){
        $subcategory=new Subcategory();
        $form = $this->createForm(SubcategoryFormType::class, $subcategory);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($subcategory);
            $em->flush();
            return $subcategory;
        }
        return $form;
    }
}