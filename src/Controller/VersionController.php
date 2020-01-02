<?php

namespace App\Controller;

use Dompdf\Dompdf;
use App\Form\VersionType;
use App\Entity\About;
use App\Entity\Langues;

use App\Entity\Loisirs;
use App\Entity\Version;
use App\Entity\Parcours;
use App\Entity\Formation;
use App\Entity\Competence;
use App\Entity\Connaissances;
use Zend\Form\Element\DateTime;
use App\Repository\VersionRepository;
use App\Repository\AboutRepository;
use Dompdf\Options;use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/version")
 */
class VersionController extends AbstractController
{       
    /**
     * @Route("/list/{id}", name="version_index", methods={"GET"})
     */
    public function index(VersionRepository $versionRepository,$id): Response
    { $repository =$this->getDoctrine()->getManager()->getRepository(user::class);
        $user=$repository->find($id);
        $em = $this->getDoctrine()->getManager();

        $version = $em->getRepository(Version::class)->findBy(array('user' => $user));

        return $this->render('version/index.html.twig', [
            'versions' => $version,
        ]);
    }

         
    /**
     * @Route("/list/{id}", name="version_list", methods={"GET"})
     */
    public function list(VersionRepository $versionRepository,$id): Response
    { $repository =$this->getDoctrine()->getManager()->getRepository(user::class);
        $user=$repository->find($id);
        $em = $this->getDoctrine()->getManager();

        $version = $em->getRepository(Version::class)->findBy(array('user' => $user));

        return $this->render('version/index.html.twig', [
            'versions' => $version,
        ]);
    }


    /**
     * @Route("/{id}/", name="version_new", methods={"GET","POST"})
     */
    public function new(Request $request,$id): Response
    {
        $repository =$this->getDoctrine()->getManager()->getRepository(user::class);
        $user=$repository->find($id);
        $version = new Version();
        
        //$datetime = new DateTime(); 
       
        // $datetime->format('Y\-m\-d\ h:i:s');
         $version->setDateCreation(new \DateTime());
        $version->setUser($user);
        //  $version->setPath($pdfFilepath);
       //   $version->setDateCreation();
          $version->setName('cv');
          $name='Cv';
          $name.=$user->getUsername();

          $date=new \DateTime();
          $result = $date->format('Y-m-d');
          $name.=$result;
          $version->setName($name);
        //  $version->set($name);
          $em = $this->getDoctrine()->getManager();
          $em->persist($version);
          $em->flush();
     
            $about = $em->getRepository(About::class)->findBy(array('user' => $user));
            $competence = $em->getRepository(Competence::class)->findBy(array('user'=>$user));
            $connaissances=$em->getRepository(Connaissances::class)->findBy(array('user' => $user));
            $formation=$em->getRepository(Formation::class)->findBy(array('user' => $user));
            $langues=$em->getRepository(Langues::class)->findBy(array('user' => $user));
            $loisirs=$em->getRepository(Loisirs::class)->findBy(array('user' => $user));
            $parcours=$em->getRepository(Parcours::class)->findBy(array('user' => $user));
        foreach ($about as $a) 
        { 
         // if($a->getVersion()==null)
           { $a->setVersion($version);}
        }

    
             $this->renderView('cv/show.html.twig',array('about'=>$about,
                'competence'=>$competence,
                'connaissances'=>$connaissances,
                'formation'=>$formation,
                'langues'=>$langues,
                'loisirs'=>$loisirs,
                'parcours'=>$parcours,
    
                ));

                
                 // Configure Dompdf according to your needs
            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Arial');
            
            // Instantiate Dompdf with our options
            $dompdf = new Dompdf($pdfOptions);

            $html = $this->renderView('cv/show.html.twig',array('about'=>$about,
            'competence'=>$competence,
            'connaissances'=>$connaissances,
            'formation'=>$formation,
            'langues'=>$langues,
            'loisirs'=>$loisirs,
            'parcours'=>$parcours

            ));

            // Load HTML to Dompdf
            $dompdf->loadHtml($html);

            // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
            $dompdf->setPaper('A4', 'portrait');
    
            // Render the HTML as PDF
            $dompdf->render();

     // Store PDF Binary Data
     $output = $dompdf->output();
        
     // In this case, we want to write the file in the public directory
 


            return     $this->render('cv/show.html.twig', [
                    'version' => $version,
                    'about'=>$about,
                    'competence'=>$competence,
                    'connaissances'=>$connaissances,
                    'formation'=>$formation,
                    'langues'=>$langues,
                    'loisirs'=>$loisirs,
                    'parcours'=>$parcours,
                ]);


    }

    /**
     * @Route("/{id}", name="version_show", methods={"GET"})
     */
    public function show(Version $version): Response
    {
        return $this->render('version/show.html.twig', [
            'version' => $version,
        ]);
    }

    /**
     * @Route("/{id}/{idv}/edit", name="version_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,$id,$idv): Response
    {
      $repository1 =$this->getDoctrine()->getManager()->getRepository(user::class);
      $user=$repository1->find($id);
      $nbr=$idv;
      $about = array();
      $competence = array();
      $connaissances = array();
      $formation = array();
      $langues = array();
      $loisirs = array();
      $parcours = array();

       $repository2 =$this->getDoctrine()->getManager()->getRepository(version::class);
      
       $version=$repository2->findBy(array('user' => $user));

       do 
       {
       // $qb = $this->getEntityManager()->createQueryBuilder();

        //$version=$repository2->find($nbr);

        $version=$repository2->find($nbr);

           if(($version!=null)&&($version->getUser()==$user))
           { 
               $aboutRepository =$this->getDoctrine()->getManager()->getRepository(about::class);
               $aboutRep=$aboutRepository->findBy(array('version'=>$version));
               foreach ($aboutRep as $a)
                  { 
                  if($a!=null)
                  { 
                     $about[] = $a;
                  }
                  }
               $competenceRepository =$this->getDoctrine()->getManager()->getRepository(competence::class);
               $competenceRep=$competenceRepository->findBy(array('version'=>$version));
               foreach ($competenceRep as $c)
                  { 
                  if($c!=null)
                   { 
                    $competence[] = $c;
                   }
                  }
          
               $connRepository =$this->getDoctrine()->getManager()->getRepository(connaissances::class);
               $connaissancesRep=$connRepository->findBy(array('version'=>$version,'user'=>$user));
               foreach ($connaissancesRep as $cn)
                  { 
                  if($cn!=null)
                   { 
                    $connaissances[] = $cn;
                   }
                  }

               $formationRepository =$this->getDoctrine()->getManager()->getRepository(formation::class);
             
               $formationRep=$formationRepository->findBy(array('version'=>$version,'user'=>$user));
               foreach ($formationRep as $f)
                  { 
                  if($f!=null)
                   { 
                    $formation[] = $f;
                   }
                  }
                  
               $languesRepository =$this->getDoctrine()->getManager()->getRepository(langues::class);
               $languesRep=$languesRepository->findBy(array('version'=>$version,'user'=>$user));
               foreach ($languesRep as $lg)
                  { 
                  if($lg!=null)
                   { 
                    $langues[] = $lg;
                   }
                  }

               $loisirsRepository =$this->getDoctrine()->getManager()->getRepository(loisirs::class);
               $loisirsRep=$loisirsRepository->findBy(array('version'=>$version,'user'=>$user));
               foreach ($loisirsRep as $l)
                  { 
                  if($l!=null)
                   { 
                    $loisirs[] = $l;
                   }
                  }

               $parcoursRepository =$this->getDoctrine()->getManager()->getRepository(parcours::class);
               $parcoursRep=$parcoursRepository->findBy(array('version'=>$version,'user'=>$user)); 
               foreach ($parcoursRep as $p)
                  { 
                  if($p!=null)
                   { 
                    $parcours[] = $p;
                   }
                  }
             } 
     
        $nbr =$nbr-1;
    
       }
     while(($nbr >0 )&&($nbr <= $idv));
  
            return $this->render('version/edit.html.twig', [
                'user'=>$user,
               'about'=> $about,
             'competence'=> $competence,
             'connaissances'=> $connaissances,
             'formation'=> $formation,
             'langues'=> $langues,
             'loisirs'=> $loisirs,
             'parcours'=> $parcours,

                ]
            
            );
    

  
     
    }

    /**
     * @Route("/{id}", name="version_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Version $version): Response
    {// $repository =$this->getDoctrine()->getManager()->getRepository(user::class);
        //$user=$repository->find($id);
        $user=$this->getUser();
        $id=$user->getId();
        if ($this->isCsrfTokenValid('delete'.$version->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
           // $entityManager->remove($langue);
           $version->setUser(null);

            $entityManager->flush();
         }
        return $this->redirectToRoute('version_Adminlist',['id' => $id]);
      
    }
     /**
     * @Route("delete/{id}", name="version_delete_user", methods={"DELETE"})
     */
    public function deleteVersion(Request $request, Version $version): Response
    {// $repository =$this->getDoctrine()->getManager()->getRepository(user::class);
        //$user=$repository->find($id);
        $user=$this->getUser();
        $id=$user->getId();
        if ($this->isCsrfTokenValid('delete'.$version->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
           // $entityManager->remove($langue);
           $version->setUser(null);

            $entityManager->flush();
         }
        return $this->redirectToRoute('version_index',['id' => $id]);
      
    }
    
/**
     * @Route("/download/{id}/{idv}", name="version_download", methods={"GET"})
     */
    public function download($id,$idv,\Knp\Snappy\Pdf $snappy)
    {
        $repository1 =$this->getDoctrine()->getManager()->getRepository(user::class);
      $user=$repository1->find($id);
      $nbr=$idv;
      $about = array();
      $competence = array();
      $connaissances = array();
      $formation = array();
      $langues = array();
      $loisirs = array();
      $parcours = array();

       $repository2 =$this->getDoctrine()->getManager()->getRepository(version::class);
      
       $version=$repository2->findBy(array('user' => $user));

       do 
       {
       // $qb = $this->getEntityManager()->createQueryBuilder();

        //$version=$repository2->find($nbr);

        $version=$repository2->find($nbr);

           if(($version!=null)&&($version->getUser()==$user))
           { 
               $aboutRepository =$this->getDoctrine()->getManager()->getRepository(about::class);
               $aboutRep=$aboutRepository->findBy(array('version'=>$version));
               foreach ($aboutRep as $a)
                  { 
                  if($a!=null)
                  { 
                     $about[] = $a;
                  }
                  }
               $competenceRepository =$this->getDoctrine()->getManager()->getRepository(competence::class);
               $competenceRep=$competenceRepository->findBy(array('version'=>$version));
               foreach ($competenceRep as $c)
                  { 
                  if($c!=null)
                   { 
                    $competence[] = $c;
                   }
                  }
          
               $connRepository =$this->getDoctrine()->getManager()->getRepository(connaissances::class);
               $connaissancesRep=$connRepository->findBy(array('version'=>$version,'user'=>$user));
               foreach ($connaissancesRep as $cn)
                  { 
                  if($cn!=null)
                   { 
                    $connaissances[] = $cn;
                   }
                  }

               $formationRepository =$this->getDoctrine()->getManager()->getRepository(formation::class);
             
               $formationRep=$formationRepository->findBy(array('version'=>$version,'user'=>$user));
               foreach ($formationRep as $f)
                  { 
                  if($f!=null)
                   { 
                    $formation[] = $f;
                   }
                  }
                  
               $languesRepository =$this->getDoctrine()->getManager()->getRepository(langues::class);
               $languesRep=$languesRepository->findBy(array('version'=>$version,'user'=>$user));
               foreach ($languesRep as $lg)
                  { 
                  if($lg!=null)
                   { 
                    $langues[] = $lg;
                   }
                  }

               $loisirsRepository =$this->getDoctrine()->getManager()->getRepository(loisirs::class);
               $loisirsRep=$loisirsRepository->findBy(array('version'=>$version,'user'=>$user));
               foreach ($loisirsRep as $l)
                  { 
                  if($l!=null)
                   { 
                    $loisirs[] = $l;
                   }
                  }

               $parcoursRepository =$this->getDoctrine()->getManager()->getRepository(parcours::class);
               $parcoursRep=$parcoursRepository->findBy(array('version'=>$version,'user'=>$user)); 
               foreach ($parcoursRep as $p)
                  { 
                  if($p!=null)
                   { 
                    $parcours[] = $p;
                   }
                  }
             } 
     
        $nbr =$nbr-1;
    
       }
     while(($nbr >0 )&&($nbr <= $idv));
     $version=$repository2->find($idv);


    

         
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
            'version'=>$version,



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
}
