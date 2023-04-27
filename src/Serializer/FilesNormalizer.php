<?php

namespace App\Serializer;

use App\entity\Files;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class FilesNormalizer implements NormalizerInterface{
    private $normalizer;
    private $urlHelper;

    public function __construct( 
        ObjectNormalizer $normalizer, 
        UrlHelper $urlHelper
        ){
        $this->normalizer = $normalizer;
        $this->urlHelper = $urlHelper;

    }

    public function normalize($file, $format = null, $context = array()){
        $data = $this->normalizer->normalize($file, $format, $context);

        if(!empty($file->getImage())){
            $data['image'] =$this->urlHelper->getAbsoluteUrl('/storage/default/' . $file->getImage());
        }

        return $data;
    }

    public function supportsNormalization($data, $format = null, $context = array()){
        return $data instanceof Files;
    }
}

