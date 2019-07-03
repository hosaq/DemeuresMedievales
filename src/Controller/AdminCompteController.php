<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminCompteController extends AbstractController
{
    /**
     * Connexion admin
     * @Route("/admin/connexion", name="admin_connexion")
     */
    public function connexion(AuthenticationUtils $utils)
    {
        $error=$utils->getLastAuthenticationError();
        $username=$utils->getLastUsername();

        $visiteur= $this->getUser();
       
        return $this->render('admin/compte/connexionadmin.html.twig', [
                'hasError'=> $error!==null,
                'username'=>$username
                ]);
        
    }

    /**
     * Deconnexion admin
     * @Route("/admin/deconnexion", name="admin_logout")
     * 
     * @return void
     */
    public function logout()
    {
       
    }
}
