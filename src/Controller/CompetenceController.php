<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Form\CompetenceType;
use App\Repository\CompetenceRepository;
use App\Entity\User;
use App\Entity\Version;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/competence")
 */
class CompetenceController extends AbstractController
{
    /**
     * @Route("/", name="competence_index", methods={"GET"})
     */
    public function index(CompetenceRepository $competenceRepository): Response
    {
        return $this->render('competence/new.html.twig', [
           'controller_name' => 'CompetenceController',
        ]);
    
    }

    /**
     * @Route("/new/{id}", name="competence_new", methods={"GET","POST"})
     */
    public function new(Request $request,$id): Response
    { $repository =$this->getDoctrine()->getManager()->getRepository(user::class);
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

        $competence = new Competence();
        $form = $this->createForm(CompetenceType::class, $competence);
        $form->handleRequest($request);
        $competence->setUser($user);



        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($version);
            $competence->setVersion($version);
            $entityManager->persist($competence);

            $entityManager->flush();

            return $this->redirectToRoute('connaissances_new', ['id' => $id]);
        }

        return $this->render('competence/new.html.twig', [
            'competence' => $competence,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="competence_show", methods={"GET"})
     */
    public function show(Competence $competence): Response
    {
        return $this->render('competence/show.html.twig', [
            'competence' => $competence,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="competence_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Competence $competence): Response
    {
        $form = $this->createForm(CompetenceType::class, $competence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('competence_index', ['id' => $competence->getId()]);
        }

        return $this->render('competence/edit.html.twig', [
            'competence' => $competence,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="competence_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Competence $competence): Response
    {
        if ($this->isCsrfTokenValid('delete'.$competence->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
           // $entityManager->remove($competence);
           $competence->setUser(null);

            $entityManager->flush();
        }

        $user=$this->getUser();
        $id=$user->getId();
        return $this->redirectToRoute('cv_edit',['id' => $id]);    }
}
