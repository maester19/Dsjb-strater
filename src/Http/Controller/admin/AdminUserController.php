<?php

namespace App\Http\Controller\admin;

use App\Domain\Auth\Users;
use App\Domain\Form\UserType;
use App\Domain\Repository\UsersRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{
    /**
     * @var UsersRepository
     */

     private $repository;

     public function __construct(UsersRepository $repository)
     {
         $this->repository = $repository;
     }

     /**
      * @Route("/admin", name="admin.user.index")
      * @return Response
      */

      public function index()
      {
          $users = $this->repository->findAll();
          return $this->render("admin/user/index.html.twig", compact("users"));
      }

      /**
       * @Route("/admin/user/create", name="admin.user.new")
       */

       public function new(Request $request)
       {
        $user = new Users;

        $form = $this->createForm(UserType::class, $user); 
        $form->handleRequest($request);  

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', "utilisateur creer avec succes");
            return $this->redirectToRoute('admin.user.index');
        }
        return $this->render("admin/user/new.html.twig", [
            "user" => $user,
            "form" => $form->createView()
        ]);
       }

      /**
       * @Route("/admin/{id}", name="admin.user.edit", methods="GET|POST")
       * @param Users $user
       * @param Request $request
       * @return Response
       */

       public function edit(Users $user, Request $request)
       {
        $form = $this->createForm(UserType::class, $user); 
        $form->handleRequest($request);  

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', "utilisateur editer avec succes");
            return $this->redirectToRoute('admin.user.index');
        }
        return $this->render("admin/user/edit.html.twig", [
            "user" => $user,
            "form" => $form->createView()
        ]);
       }

       /**
        * @Route("/admin/user/show/{id}", name="admin.user.show")
        * @param Users $user
        * @return Response
        */

        public function show(Users $user): Response
        {
            return $this->render("admin/user/show.html.twig", [
                "user" => $user
            ]);
        }

       /**
        * @Route("/admin/user/{id}", name="admin.user.delete", methods="DELETE")
        * @param Users $user
        * @return Response
        */

        public function delete(Users $user, Request $request)
        {
            if($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token')))
            {
                $em = $this->getDoctrine()->getManager();
                $em->remove($user);
                $em->flush();
                $this->addFlash('success', "Utilisateur supprimer avec succes");
            }
            return $this->redirectToRoute("admin.user.index");
        }

}