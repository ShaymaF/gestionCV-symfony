<?php

namespace App\Controller;

use App\Entity\Cv;
use App\Entity\User;
use App\Form\CvType;
use App\Entity\Version;
use App\Form\AboutType;
use App\Form\CompetenceType;
use App\Form\ConnaissancesType;
use App\Form\FormationType;
use App\Form\LoisirsType;
use App\Form\LanguesType;
use App\Form\ParcoursType;


use App\Entity\About;
use App\Entity\Langues;
use App\Entity\Loisirs;
use App\Entity\Parcours;
use App\Entity\Formation;
use App\Entity\Competence;
use App\Entity\Connaissances;
use App\Repository\CvRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/cv")
 */
class CvController extends AbstractController
{
    /**
     * @Route("/{id}", name="cv_index", methods={"GET"})
     */
    public function index($id)
    {
        $repository =$this->getDoctrine()->getManager()->getRepository(user::class);
        $user=$repository->find($id);
     
        $em=$this->getDoctrine()->getManager();
        $about = $em->getRepository(About::class)->findBy(array('user' => $user));
        $competence = $em->getRepository(Competence::class)->findBy(array('user'=>$user));
        $connaissances=$em->getRepository(Connaissances::class)->findBy(array('user' => $user));
        $formation=$em->getRepository(Formation::class)->findBy(array('user' => $user));
        $langues=$em->getRepository(Langues::class)->findBy(array('user' => $user));
        $loisirs=$em->getRepository(Loisirs::class)->findBy(array('user' => $user));
        $parcours=$em->getRepository(Parcours::class)->findBy(array('user' => $user));


        return $this->render('cv/index.html.twig',array(
            'user'=>$user,
            'about'=>$about,
            'competence'=>$competence,
            'connaissances'=>$connaissances,
            'formation'=>$formation,
            'langues'=>$langues,
            'loisirs'=>$loisirs,
            'parcours'=>$parcours

            ));
    }

    /**
     * @Route("/new", name="cv_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cv = new Cv();
        $form = $this->createForm(CvType::class, $cv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cv);
            $entityManager->flush();

            return $this->redirectToRoute('about_new');
        }

        return $this->render('cv/new.html.twig', [
            'cv' => $cv,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("show/{id}", name="cv_show", methods={"GET"})
     */
    public function show(Cv $cv): Response
    {
        return $this->render('cv/show.html.twig', [
            'cv' => $cv,
        ]);
    }
     /**
     * @Route("footer/", name="footer", methods={"GET"})
     */
    public function indexfooter(): Response
    {
        return $this->render('cv/footer.html.twig');
    }


    /**
     * @Route("/{id}/edit", name="cv_edit", methods={"GET","POST"})
     */
    public function index2($id,Request $requestComp,Request $requestConn,
    Request $requestAbout,Request $requestForm,Request $requestLang,
    Request $requestLoisir,Request $requestParcour): Response

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
           $entityManager = $this->getDoctrine()->getManager();
        
           $idv=$version->getId();
           echo("<script>console.log('idversion: " . $idv . "');</script>");

        $about = new About();
        $formAbout = $this->createForm(AboutType::class, $about);
        $formAbout->handleRequest($requestAbout);

        $competence = new Competence();
        $formComp = $this->createForm(CompetenceType::class, $competence);
        $formComp->handleRequest($requestComp);

        $connaissances = new Connaissances();
        $formConn = $this->createForm(ConnaissancesType::class, $connaissances);
        $formConn->handleRequest($requestConn);

        $formation = new Formation();
        $formForm = $this->createForm(FormationType::class, $formation);
        $formForm->handleRequest($requestForm);

        $langues = new Langues();
        $formLang= $this->createForm(LanguesType::class, $langues);
        $formLang->handleRequest($requestLang);

        $loisirs = new Loisirs();
        $formLoisir = $this->createForm(LoisirsType::class, $loisirs);
        $formLoisir->handleRequest($requestLoisir);

        $parcours = new Parcours();
        $formParcour = $this->createForm(ParcoursType::class, $parcours);
        $formParcour->handleRequest($requestParcour);

        $about->setUser($user);
        $competence->setUser($user);
        $connaissances->setUser($user);
        $formation->setUser($user);
        $langues->setUser($user);
        $loisirs->setUser($user);
        $parcours->setUser($user);

        $entityManager = $this->getDoctrine()->getManager();

             if ($formAbout->isSubmitted() && $formAbout->isValid())
            
             {
                // $repository =$this->getDoctrine()->getManager()->getRepository(version::class);
                 //$version=$repository->find($idv);
                //  $about->addVersion($version);
               $entityManager->persist($version);
               $about->setVersion($version);
               $entityManager->persist($about);

                $entityManager->flush();
    
        return $this->redirectToRoute('cv_edit', ['id' => $id]);
            }
             else if ($formComp->isSubmitted() && $formComp->isValid())
             
             {
                $entityManager->persist($version);
                $competence->setVersion($version);
                $entityManager->persist($competence);
                $entityManager->flush();
    
               // return $this->redirectToRoute('cv_edit', ['id' => $id]);
            }
            else if ($formConn->isSubmitted() && $formConn->isValid())
             
             { 
                $entityManager->persist($version);
                $connaissances->setVersion($version);
                $entityManager->persist($connaissances);
                $entityManager->flush();
    
               // return $this->redirectToRoute('cv_edit', ['id' => $id]);
            }
            else if  ($formForm->isSubmitted() && $formForm->isValid())
              
             {
                $entityManager->persist($version);
                $formation->setVersion($version);
                $entityManager->persist($formation);
                $entityManager->flush();
    
               // return $this->redirectToRoute('cv_edit', ['id' => $id]);
            }
           else  if ($formLang->isSubmitted() && $formLang->isValid())
             
             {
                $entityManager->persist($version);
                $langues->setVersion($version);
                $entityManager->persist($langues);
                $entityManager->flush();
    
               // return $this->redirectToRoute('cv_edit', ['id' => $id]);
            }
           else  if  ($formLoisir->isSubmitted() && $formLoisir->isValid())
             
             {
                $entityManager->persist($version);
                $loisirs->setVersion($version);
                $entityManager->persist($loisirs);
                $entityManager->flush();
    
               // return $this->redirectToRoute('cv_edit', ['id' => $id]);
            }
           else  if  ($formParcour->isSubmitted() && $formParcour->isValid())
             
             {
                $entityManager->persist($version);
                $parcours->setVersion($version);
                $entityManager->persist($parcours);
                $entityManager->flush();

           // return $this->redirectToRoute('cv_edit', ['id' => $id]);
        }
     
        $em=$this->getDoctrine()->getManager();
        $about1 = $em->getRepository(About::class)->findBy(array('user' => $user));
        $competence1 = $em->getRepository(Competence::class)->findBy(array('user'=>$user));
        $connaissances1=$em->getRepository(Connaissances::class)->findBy(array('user' => $user));
        $formation1=$em->getRepository(Formation::class)->findBy(array('user' => $user));
        $langues1=$em->getRepository(Langues::class)->findBy(array('user' => $user));
        $loisirs1=$em->getRepository(Loisirs::class)->findBy(array('user' => $user));
        $parcours1=$em->getRepository(Parcours::class)->findBy(array('user' => $user));


        return $this->render('cv/edit.html.twig',array('about'=>$about1,
            'competence'=>$competence1,
            'connaissances'=>$connaissances1,
            'formation'=>$formation1,
            'langues'=>$langues1,
            'loisirs'=>$loisirs1,
            'parcours'=>$parcours1,
            'formAbout' => $formAbout->createView(),
            'formComp' => $formComp->createView(),
            'formConn' => $formConn->createView(),
            'formForm' => $formForm->createView(),
            'formLang' => $formLang->createView(),
            'formLoisir' => $formLoisir->createView(),
            'formParcour' => $formParcour->createView(),
            'user'=>$user,

            
            
            ));
    }
    
    /**
     * @Route("/{id}", name="cv_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Cv $cv): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cv->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cv);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cv_index');
    }
     /**
     * @Route("/download/{id}", name="cv_download", methods={"GET"})
     */
    public function download($id,\Knp\Snappy\Pdf $snappy)
    {
        $repository =$this->getDoctrine()->getManager()->getRepository(user::class);
        $user=$repository->find($id);

        $em=$this->getDoctrine()->getManager();
        $about = $em->getRepository(About::class)->findBy(array('user' => $user));
        $competence = $em->getRepository(Competence::class)->findBy(array('user'=>$user));
        $connaissances=$em->getRepository(Connaissances::class)->findBy(array('user' => $user));
        $formation=$em->getRepository(Formation::class)->findBy(array('user' => $user));
        $langues=$em->getRepository(Langues::class)->findBy(array('user' => $user));
        $loisirs=$em->getRepository(Loisirs::class)->findBy(array('user' => $user));
        $parcours=$em->getRepository(Parcours::class)->findBy(array('user' => $user));

         
      //  $snappy = $this->get('knp_snappy.pdf');
        
        $html = $this->renderView('cv/pdf.html.twig', array(
            //..Send some data to your view if you need to //
            'about'=>$about,
            'competence'=>$competence,
            'connaissances'=>$connaissances,
            'formation'=>$formation,
            'langues'=>$langues,
            'loisirs'=>$loisirs,
            'parcours'=>$parcours,
            'user'=>$user,


        ));

$html .= '<style>';
$html .= '  @import url("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css");';
$html .= '</style>';
$filename = 'myCv';
            
$footer = $this->renderView('cv/footer.html.twig');


$options = [
'orientation'   => 'portrait',
          'encoding'      => 'UTF-8',
          'footer-html'   => $footer,

];       
        return new Response(
            $snappy->getOutputFromHtml($html,$options),
              200,
            array(
                'orientation' => 'Landscape',
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"',

            )
        );
    
          //  $html .= '<img class="bi x0 y0 w0 h0" alt="" src="assets/OutDocument/bg1.png"/>';

            //$html .= '<img class="bi x0 y0 w0 h0" alt="" src="assets/OutDocument/bg2.png"/>';
           // $html .= '<link rel="stylesheet" href="assets/OutDocument/base.min.css"/>';
           // $html .= '<link rel="stylesheet" href="assets/OutDocument/fancy.min.css"/>';
           // $html .= '<link rel="stylesheet" href="assets/OutDocument/main.css"/>';
          //  $html .= '<link rel="stylesheet" href="assets/css/bootstrap.css">';
          //  $html .= '<script src="assets/OutDocument/compatibility.min.js"></script>';
           // $html .= ' <script src="assets/OutDocument/theViewer.min.js"></script>';


        
        }
    
         /**
     * @Route("/{id}", name="cv_version", methods={"GET","POST"})
     */
    public function version($id):Response
    {
       
        $repository =$this->getDoctrine()->getManager()->getRepository(user::class);
        $user=$repository->find($id);
        $version = new Version();
    
        $version->setUser($user);
        //  $version->setPath($pdfFilepath);
       //   $version->setDateCreation();
          $version->setName('cv');



        $em=$this->getDoctrine()->getManager();
        $em->persist($version);
        $em->flush();

        $about = $em->getRepository(About::class)->findBy(array('user' => $user));
        $competence = $em->getRepository(Competence::class)->findBy(array('user'=>$user));
        $connaissances=$em->getRepository(Connaissances::class)->findBy(array('user' => $user));
        $formation=$em->getRepository(Formation::class)->findBy(array('user' => $user));
        $langues=$em->getRepository(Langues::class)->findBy(array('user' => $user));
        $loisirs=$em->getRepository(Loisirs::class)->findBy(array('user' => $user));
        $parcours=$em->getRepository(Parcours::class)->findBy(array('user' => $user));


          return $this->renderView('cv/index.html.twig',array('about'=>$about,
            'competence'=>$competence,
            'connaissances'=>$connaissances,
            'formation'=>$formation,
            'langues'=>$langues,
            'loisirs'=>$loisirs,
            'parcours'=>$parcours,
            'user'=>$user,

            ));

          
  
  // Send some text response
 // return new Response("The PDF file has been succesfully generated !");

  
    }
       /**
     * @Route("/aboutForm/{id}", name="aboutForm", methods={"GET","POST"})
     */
    public function aboutForm(Request $request,$id): Response{
        $repository =$this->getDoctrine()->getManager()->getRepository(user::class);
        $user=$repository->find($id);


        $about = new About();
        $form = $this->createForm(AboutType::class, $about);
        $form->handleRequest($request);

        $about->setUser($user);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($about);
            $entityManager->flush();

            return $this->redirectToRoute('cv_edit', ['id' => $id]);
        }

        return $this->render('cv/edit.html.twig', [
            'about' => $about,
            'form' => $form->createView(),
        ]);
    }

}
