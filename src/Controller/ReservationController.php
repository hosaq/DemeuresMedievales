<?php

namespace App\Controller;

use App\Entity\Immo;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{
    /**
     * affiche et traite le formulaire de reservation
     * @Route("/annonce/{slug}/reservation", name="reservation_creer")
     * @IsGranted("ROLE_USER")
     */
    public function reserver(Immo $annonce,Request $request, ObjectManager $manager)
    {
        $reservation=new Reservation();
        $form=$this->createForm(ReservationType::class,$reservation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user=$this->getUser();
            $reservation->setBooker($user)
                        ->setAnnonce($annonce)
                        ;
            if (!$reservation->sontReservables()){
                $this->addFlash('warning',"Les dates que vous avez choisies ne sont pas disponibles");
            }else{

            $manager->persist($reservation);
            $manager->flush();

            return $this->redirectToRoute('reservation_voir',['id'=>$reservation->getId(),
            'withAlert'=>true]);
            }
        }

        return $this->render('reservation/reserver.html.twig', [
            'annonce'=> $annonce,
            'form'=>$form->createView()
        ]);
    }

    /**
     * montre une reservation
     * @Route("/reservation/{id}", name="reservation_voir")
     * @Security("is_granted('ROLE_USER') and (user === reservation.getBooker() or 
      user === reservation.getAnnonce().getProprio()) or is_granted('ROLE_ADMIN')",
      message="Cette annonce ne vous appartient pas, vous ne pouvez pas la modifier." )
     */
    public function voirreservervation(Reservation $reservation)
    {
        return $this->render('reservation/voirreserve.html.twig', [
            'reservation'=> $reservation,
            
        ]);
    }
}
