<?php

namespace App\Controller;

use App\Entity\Immo;
use App\Form\AnnonceType;
use App\Repository\ImmoRepository;
use App\Service\PaginationService;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminImmoController extends AbstractController
{
    /**
     * @Route("/admin/annonces/{page<\d+>?1}", name="admin_annonces")
     */
    public function index(ImmoRepository $repo, $page=1, PaginationService $pagination)
    {
        $pagination->setEntityClass(Immo::class)
                    ->setPageactuelle($page);
        
        return $this->render('admin/immo/recapitulatif.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * moderer une annonce
     * @Route("/admin/annonce/{slug}",name="moderer_annonce")
     */
    public function moderer(Immo $annonce,Request $request, ObjectManager $manager){
       

        $form=$this->createForm(AnnonceType::class,$annonce);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            foreach($annonce->getImages() as $image){
                $image->setImmo($annonce);
            }

            $manager->persist($annonce);
            $manager->flush();
            $this->addFlash(
                'success',
                "Les modifications de votre annonce <strong>{$annonce->getTitre()} </strong>ont bien été enregistrées."
            );
            return $this->redirectToRoute('cette_annonce',[
                'slug'=>$annonce->getSlug()
            ]);
        }


        return $this->render('admin/immo/modererannonce.html.twig',[
            'form'=>$form->createView(),
            'annonce'=>$annonce
        ]);


    }

    /**
     * supprime une annonce si elle n'a pas de reservation
     * 
     * @Route("/admin/annonce/{slug}/supprimer", name="admin_supprimer_annonce")
     * 
     * 
     */
    public function delete(Immo $annonce, ObjectManager $manager){
         if(count($annonce->getReservations())>0){
            $this->addFlash(
                'warning',
                "L'annonce <strong>{$annonce->getTitre()} </strong> comporte des réservations, 
                elle ne peut être supprimée."
            );
         }else{  
            $manager->remove($annonce);
            $manager->flush();
            $this->addFlash(
                'success',
                "L'annonce <strong>{$annonce->getTitre()} </strong>a bien été supprimée."
            );
        }
        return $this->redirectToRoute('admin_annonces');
    


    
}
}
