<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {    $repo=$this->getDoctrine()->getRepository(User::class);
        $users=$repo->findAll();
         #users=["username1","username2","username3"];
    # $users=[1, {"username": "username1","email":"@","password":""}]
        return $this->render('user/index.html.twig', [
            'users' => '$users',
        ]);
    }
    
     /**
     * @Route("/user/add1", name="add1")
     */
    public function new(Request $request): Response
    {
        $user = new User();
    
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original $task variable has also been updated
           $user = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($user);
             $entityManager->flush();

            return $this->redirectToRoute('user');
        }

        return $this->renderForm('user/new.html.twig', [
            'formuser' => $form,

        ]);
    }
    
}



