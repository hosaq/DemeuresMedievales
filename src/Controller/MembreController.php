<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MembreController extends AbstractController
{
    /**
     * @Route("/membre/{slug}", name="membre_afficher")
     */
    public function membre(User $user)
    {
        return $this->render('membre/affichermembre.html.twig', [
            'membre' => $user,
        ]);
    }
    /**
     *
     * @Route("/reservations/{slug}", name="les_reservations")
     * @Security("is_granted('ROLE_USER') or is_granted('ROLE_ADMIN')",
     * message="Cette annonce ne vous appartient pas, vous ne pouvez pas la modifier." )
     */
    public function mesReservations(User $user)
    {
        $visiteur= $this->getUser();
        $roles=$visiteur->getRoles();
    
        
        if($user===$visiteur || in_array("ROLE_ADMIN", $roles)){
            return $this->render('membre/mesreservations.html.twig', [
                'membre' => $user,
            ]);
        }else{
            return $this->redirectToRoute("les_annonces");
        }
    }
}
