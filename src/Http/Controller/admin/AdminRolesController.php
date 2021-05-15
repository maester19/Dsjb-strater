<?php

namespace App\Http\Controller\admin;

use App\Domain\Auth\Roles;
use App\Domain\Form\RolesType;
use App\Domain\Repository\RolesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/roles")
 */
class AdminRolesController extends AbstractController
{
    /**
     * @Route("/", name="admin.roles.index", methods={"GET"})
     */
    public function index(RolesRepository $rolesRepository): Response
    {
        return $this->render('admin/roles/index.html.twig', [
            'roles' => $rolesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin.roles.new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $roles = new Roles();
        $form = $this->createForm(RolesType::class, $roles);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($roles);
            $entityManager->flush();

            return $this->redirectToRoute('admin.roles.index');
        }

        return $this->render('admin/roles/new.html.twig', [
            'roles' => $roles,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.roles.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Roles $roles): Response
    {
        $form = $this->createForm(RolesType::class, $roles);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.roles.index');
        }

        return $this->render('admin/roles/edit.html.twig', [
            'roles' => $roles,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.roles.delete", methods={"POST"})
     */
    public function delete(Request $request, Roles $roles): Response
    {
        if ($this->isCsrfTokenValid('delete'.$roles->getId(), $request->get('_token'))) {
            //$entityManager = $this->getDoctrine()->getManager();
           // $entityManager->remove($roles);
            //$entityManager->flush();
            return new Response("suppression");
        }

        return $this->redirectToRoute('admin.roles.index');
    }
}
