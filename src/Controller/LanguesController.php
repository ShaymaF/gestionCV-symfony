<?php

namespace App\Controller;

use App\Entity\Langues;
use App\Entity\User;
use App\Entity\Version;

use App\Form\LanguesType;
use App\Repository\LanguesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/langues")
 */
class LanguesController extends AbstractController
{
    /**
     * @Route("/", name="langues_index", methods={"GET"})
     */
    public function index(LanguesRepository $languesRepository): Response
    {
        return $this->render('langues/index.html.twig', [
            'langues' => $languesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="langues_new", methods={"GET","POST"})
     */
    public function new(Request $request,$id): Response
    {

        $repository =$this->getDoctrine()->getManager()->getRepository(user::class);
        $user=$repository->find($id);

        $version = new Version();
        $version->setDateCreation(new \DateTime());
         $version->setUser($user);
       $version->setName('cv');
           $name='Cv';
           $name.=$user->getUsername();
 
            $date=new \DateTime();
            $result = $date->format('Y-m-d');
           $name.=$result;
            $version->setName($name);

        $langue = new Langues();
        $form = $this->createForm(LanguesType::class, $langue);
        $form->handleRequest($request);

        $langue->setUser($user);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($version);
            $langue->setVersion($version);
            $entityManager->persist($langue);
            $entityManager->flush();

            return $this->redirectToRoute('loisirs_new', ['id' => $id]);
        }

        return $this->render('langues/new.html.twig', [
            'langue' => $langue,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="langues_show", methods={"GET"})
     */
    public function show(Langues $langue): Response
    {
        return $this->render('langues/show.html.twig', [
            'langue' => $langue,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="langues_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Langues $langue): Response
    {
      
        $form = $this->createForm(LanguesType::class, $langue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('langues_index',['id' => $langue->getId()]);
        }

        return $this->render('langues/edit.html.twig', [
            'langue' => $langue,
        
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="langues_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Langues $langue): Response
    { 
        $user=$this->getUser();
        $id=$user->getId();
        if ($this->isCsrfTokenValid('delete'.$langue->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
           // $entityManager->remove($langue);
           $langue->setUser(null);

            $entityManager->flush();
        }

        return $this->redirectToRoute('cv_edit',['id' => $id]);
    }
}
