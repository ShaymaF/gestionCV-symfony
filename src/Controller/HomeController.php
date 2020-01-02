<?php
// src/Controller/EditUser/AuthenticationController.php
namespace App\Controller;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
class HomeController extends Controller
{
     /**
     * @Route("/welcome", name="welcome")
     */
    public function index()
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
      /**
     * @Route("/", name="welcome1")
     */
    public function index1(Security $security,AuthorizationCheckerInterface $authChecker)
    {
        $user = $security->getUser();

         if (true === $authChecker->isGranted('ROLE_ADMIN')){
            $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('user/index.html.twig', [
            'controller_name' => 'HomeController',
            'users'=>  $users,

        ]);}
      else if (true === $authChecker->isGranted('ROLE_USER')){
            return $this->render('base.html.twig', [
                'controller_name' => 'HomeController',
            ]);
   }
             return $this->redirectToRoute('welcome');

    }
          /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        return $this->render('admin.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/logout", name="logout", methods={"GET"})
     */
    public function logout()
    {
    }
}
