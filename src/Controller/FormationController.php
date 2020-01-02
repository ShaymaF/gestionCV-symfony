<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Entity\User;
use App\Entity\Version;

use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/formation")
 */
class FormationController extends AbstractController
{
    /**
     * @Route("/", name="formation_index", methods={"GET"})
     */
    public function index(FormationRepository $formationRepository): Response
    {
        return $this->render('formation/index.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="formation_new", methods={"GET","POST"})
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

        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        $formation->setUser($user);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($version);
            $formation->setVersion($version);
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute('langues_new', ['id' => $id]);
        }

        return $this->render('formation/new.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="formation_show", methods={"GET"})
     */
    public function show(Formation $formation): Response
    {
        return $this->render('formation/show.html.twig', [
            'formation' => $formation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="formation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Formation $formation): Response
    {
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cv_edit', ['id' => $formation->getId()]);
        }

        return $this->render('formation/edit.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="formation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Formation $formation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            //$entityManager->remove($formation);
            $formation->setUser(null);

            $entityManager->flush();
        }

        $user=$this->getUser();
        $id=$user->getId();
        return $this->redirectToRoute('cv_edit',['id' => $id]);    }
}
