<?php

namespace App\Controller;

use App\Entity\Parcours;
use App\Form\ParcoursType;
use App\Entity\User;
use App\Entity\Version;

use App\Repository\ParcoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/parcours")
 */
class ParcoursController extends AbstractController
{
    /**
     * @Route("/", name="parcours_index", methods={"GET"})
     */
    public function index(ParcoursRepository $parcoursRepository): Response
    {
        return $this->render('parcours/index.html.twig', [
            'parcours' => $parcoursRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="parcours_new", methods={"GET","POST"})
     */
    public function new(Request $request,$id): Response
    {
        $repository =$this->getDoctrine()->getManager()->getRepository(user::class);
        $user=$repository->find($id);
$user->setHasCv(true);
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

        $parcour = new Parcours();
        $form = $this->createForm(ParcoursType::class, $parcour);
        $form->handleRequest($request);

        $parcour->setUser($user);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);

            $entityManager->persist($version);
            $parcour->setVersion($version);
            $entityManager->persist($parcour);
            $entityManager->flush();

            return $this->redirectToRoute('cv_edit',['id' => $id]);
        }

        return $this->render('parcours/new.html.twig', [
            'parcour' => $parcour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="parcours_show", methods={"GET"})
     */
    public function show(Parcours $parcour): Response
    {
        return $this->render('parcours/show.html.twig', [
            'parcour' => $parcour,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="parcours_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Parcours $parcour): Response
    {
        $form = $this->createForm(ParcoursType::class, $parcour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('parcours_index',['id' => $parcour->getId()]);
        }

        return $this->render('parcours/edit.html.twig', [
            'parcour' => $parcour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="parcours_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Parcours $parcour): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parcour->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
           // $entityManager->remove($parcour);
           $parcour->setUser(null);

            $entityManager->flush();
        }

        $user=$this->getUser();
        $id=$user->getId();
        return $this->redirectToRoute('cv_edit',['id' => $id]);    }
}
