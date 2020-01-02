<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use App\Form\VersionType;
use App\Entity\About;
use App\Entity\Langues;
use App\Form\AboutType;
use App\Form\CompetenceType;
use App\Form\ConnaissancesType;
use App\Form\FormationType;
use App\Form\LoisirsType;
use App\Form\LanguesType;
use App\Form\ParcoursType;
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
class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
       /**
     * @Route("/listVersion/{id}", name="version_Adminlist", methods={"GET"})
     */
    public function list(VersionRepository $versionRepository,$id): Response
    { $repository =$this->getDoctrine()->getManager()->getRepository(user::class);
        $user=$repository->find($id);
        $em = $this->getDoctrine()->getManager();

        $version = $em->getRepository(Version::class)->findBy(array('user' => $user));

        return $this->render('admin/listVersion.html.twig', [
            'versions' => $version,
        ]);
    }

    /**
     * @Route("/{id}/{idv}/editVersion", name="version_admin", methods={"GET","POST"})
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
  
            return $this->render('admin/version.html.twig', [
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
     * @Route("/{id}/CVedit", name="cv_Adminedit", methods={"GET","POST"})
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
    
        return $this->redirectToRoute('cv_Adminedit', ['id' => $id]);
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


        return $this->render('admin/cv.html.twig',array('about'=>$about1,
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

}
