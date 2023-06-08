<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login', methods:['POST'])]
    public function login(Request $request,#[CurrentUser] User $user = null):Response
    {
        // // obtenemos los datos del inicio de sesion
        $username = $request->request->get('username');
        $password = $request->request->get('password');




       // return $this->json($request);
       return $this->json(['user'=>$user ?  $user->getId():null ]);
    }
}
