<?php

namespace App\Controller;

use App\Entity\About;
use App\Form\AboutType;
use App\Entity\User;
use App\Entity\Version;

use App\Repository\AboutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/about")
 */
class AboutController extends AbstractController
{
    /**
     * @Route("/", name="about_index")
     */
    public function index(AboutRepository $aboutRepository): Response
    {
        return $this->render('about/new.html.twig', [
            'controller_name' => 'AboutController',
        ]);
    }


    /**
     * @Route("/new/{id}", name="about_new", methods={"GET","POST"})
     */
    public function new(Request $request,$id): Response{
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

        $about = new About();
        $form = $this->createForm(AboutType::class, $about);
        $form->handleRequest($request);

        $about->setUser($user);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($version);
            $about->setVersion($version);
            $entityManager->persist($about);
            $entityManager->flush();

         return $this->redirectToRoute('competence_new', ['id' => $id]);
        }

        return $this->render('about/new.html.twig', [
            'about' => $about,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="about_show", methods={"GET"})
     */
    public function show(About $about): Response
    {
        return $this->render('about/show.html.twig', [
            'about' => $about,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="about_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, About $about): Response
    {
        $form = $this->createForm(AboutType::class, $about);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('about_index', ['id' => $about->getId()]);
        }

        return $this->render('about/edit.html.twig', [
            'about' => $about,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="about_delete", methods={"DELETE"})
     */
    public function delete(Request $request, About $about): Response
    {
        if ($this->isCsrfTokenValid('delete'.$about->getId(), $request->request->get('_token'))) {

        $entityManager = $this->getDoctrine()->getManager();
            //$entityManager->remove($about);
            $about->setUser(null);

         $entityManager->flush();
        }

        $user=$this->getUser();
        $id=$user->getId();
        return $this->redirectToRoute('cv_edit',['id' => $id]);    }
}
