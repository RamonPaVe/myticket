<?php

namespace App\Controller\Api;

use App\Entity\Files;
use App\Form\Model\FilesDto;
use App\Form\Type\FilesFormType;
use App\Repository\FilesRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use League\Flysystem\FilesystemOperator;


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
        EntityManagerInterface $em, Request $request, FilesystemOperator $defaultStorage
    ){
        $fileDto=new FilesDto();
        $form = $this->createForm(FilesFormType::class, $fileDto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $extension = explode('/', mime_content_type($fileDto->base64Image))[1];
            $data = explode(',',$fileDto->base64Image);
            $filename = sprintf('%s.%s', uniqid('file_', true),$extension);
            $defaultStorage->write($filename, base64_decode($data[1]));
            $file=new Files();
            $file->setFileName($fileDto->file_name);
            $file->setImage($filename);
            $em->persist($file);
            $em->flush();
            return $file;
        }
        return $form;
    }
}