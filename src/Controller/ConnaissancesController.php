<?php

namespace App\Controller;

use App\Entity\Connaissances;
use App\Form\ConnaissancesType;
use App\Entity\User;
use App\Entity\Version;

use App\Repository\ConnaissancesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/connaissances")
 */
class ConnaissancesController extends AbstractController
{
    /**
     * @Route("/", name="connaissances_index", methods={"GET"})
     */
    public function index(ConnaissancesRepository $connaissancesRepository): Response
    {
        return $this->render('connaissances/index.html.twig', [
            'connaissances' => $connaissancesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="connaissances_new", methods={"GET","POST"})
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

        $connaissance = new Connaissances();
        $form = $this->createForm(ConnaissancesType::class, $connaissance);
        $form->handleRequest($request);

        $connaissance->setUser($user);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($version);
            $connaissance->setVersion($version);
            $entityManager->persist($connaissance);
            $entityManager->flush();

            return $this->redirectToRoute('formation_new', ['id' => $id]);
        }

        return $this->render('connaissances/new.html.twig', [
            'connaissance' => $connaissance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="connaissances_show", methods={"GET"})
     */
    public function show(Connaissances $connaissance): Response
    {
        return $this->render('connaissances/show.html.twig', [
            'connaissance' => $connaissance,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="connaissances_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Connaissances $connaissance): Response
    {
        $form = $this->createForm(ConnaissancesType::class, $connaissance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('connaissances_index',['id' => $connaissance->getId()]);
        }

        return $this->render('connaissances/edit.html.twig', [
            'connaissance' => $connaissance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="connaissances_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Connaissances $connaissance): Response
    {
        if ($this->isCsrfTokenValid('delete'.$connaissance->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            //$entityManager->remove($connaissance);
            $connaissance->setUser(null);

            $entityManager->flush();
        }

        $user=$this->getUser();
        $id=$user->getId();
        return $this->redirectToRoute('cv_edit',['id' => $id]);    }
}
