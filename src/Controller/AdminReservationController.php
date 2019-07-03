<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Reservation;
use App\Form\CommentaireType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminReservationController extends AbstractController
{
    /**
     * montre une reservation et sauvegarde un commentaire
     * @Route("/admin/reservation/{id}", name="admin_reservation_voir")
     * 
     */
    public function adminvoirreservervation(Reservation $reservation,Request $request, ObjectManager $manager)
    {
        $booker=$reservation->getBooker();
        $loc=$reservation->getAnnonce();
        $commentaire=$loc->obtenircommentaireAuteur($booker);
        $form=$this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user=$booker;
            $commentaire->setAuteur($user)
                        ->setAnnonce($reservation->getAnnonce())
            ;
            $manager->persist($commentaire);
            $manager->flush();
            $this->addFlash(
                'success',
                "Votre commentaire a bien été pris en compte."
            );
        }
        return $this->render('admin/admin_reservation/adminvoirreserve.html.twig', [
            'reservation'=> $reservation,
            'form'=>$form->createView(),
            
        ]);
    }
}
