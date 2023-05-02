<?php

namespace App\Controller\Api;

use App\Entity\Files;
use App\Form\Model\FilesDto;
use App\Form\Type\FilesFormType;
use App\Repository\FilesRepository;
use App\Service\FileUploader;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\HttpFoundation\Response;

class FilesController extends AbstractFOSRestController{
    /**
     * @Rest\Get(path="/files")
     * @Rest\View(serializerGroups={"files"}, serializerEnableMaxDepthChecks=true)
     */
    public function getActions(
        FilesRepository $filesRepository
    ){
        return $filesRepository->findAll();
    }


     /**
     * @Rest\Post(path="/files")
     * @Rest\View(serializerGroups={"files"}, serializerEnableMaxDepthChecks=true)
     */
    public function postActions(
        EntityManagerInterface $em, Request $request, FileUploader $fileUploader
    ){
        $fileDto=new FilesDto();
        $form = $this->createForm(FilesFormType::class, $fileDto);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            return new Response('', Response::HTTP_BAD_REQUEST);
        }
        if($form->isValid()){
            $file=new Files();
            $file->setFileName($fileDto->file_name);
            if($fileDto->base64Image){
                $filename = $fileUploader->uploadBase64File($fileDto->base64Image);
                $file->setImage($filename);
            }
            $em->persist($file);
            $em->flush();
            return $file;
        }
        return $form;
    }
}