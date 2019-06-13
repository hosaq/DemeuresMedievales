<?php

namespace App\Controller;

use App\Entity\Immo;
use App\Entity\Image;
use App\Form\AnnonceType;
use App\Repository\ImmoRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ImmoController extends AbstractController
{
    /**
     * liste des annonces
     * @Route("/annonces", name="les_annonces")
     */
    public function index(ImmoRepository $repo)
    {
        
        $biens=$repo->findAll();
        return $this->render('immo/index.html.twig', [
            'biens' => $biens,
        ]);
    }

    /**
     * montre une annonce
     * @Route("/annonce/{slug}", name="cette_annonce")
     * @return Response
     */
    public function annonce(Immo $bien)
    {
        return $this->render('immo/bien.html.twig', [
            'bien' => $bien,
        ]);
    }
    
    /**
     * creer une annonce
     * 
     * @Route("/creer/annonce", name="nouveau_bien")
     * @IsGranted("ROLE_USER")
     */
    public function creer(Request $request, ObjectManager $manager){
        $annonce=new Immo();

        $form=$this->createForm(AnnonceType::class,$annonce);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            foreach($annonce->getImages() as $image){
                $image->setImmo($annonce);
                $manager->persist($image);
            }
            $annonce->setProprio($this->getUser());
            $manager->persist($annonce);
            $manager->flush();
            $this->addFlash(
                'success',
                "Votre annonce <strong>{$annonce->getTitre()} </strong>a bien été enregistrée."
            );
            return $this->redirectToRoute('cette_annonce',[
                'slug'=>$annonce->getSlug()
            ]);
        }


        return $this->render('immo/nouveau.html.twig',[
            'form'=>$form->createView()
        ]);


    }


    /**
     * edite une annonce
     * 
     * @Route("/annonce/{slug}/editer", name="modifier_annonce")
     * @Security("is_granted('ROLE_USER') and user === annonce.getProprio() or is_granted('ROLE_ADMIN')",
     * message="Cette annonce ne vous appartient pas, vous ne pouvez pas la modifier." )
     * 
     */
    public function editer(Immo $annonce,Request $request, ObjectManager $manager){
       

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


        return $this->render('immo/edite.html.twig',[
            'form'=>$form->createView()
        ]);


    }

    /**
     * supprime une annonce
     * 
     * @Route("/annonce/{slug}/supprimer", name="supprimer_annonce")
     * @Security("is_granted('ROLE_USER') and user === annonce.getProprio() or is_granted('ROLE_ADMIN')",
     * message="Cette annonce ne vous appartient pas, vous ne pouvez pas la modifier." )
     * 
     */
    public function delete(Immo $annonce, ObjectManager $manager){
       

            $manager->remove($annonce);
            $manager->flush();
            $this->addFlash(
                'success',
                "L'annonce <strong>{$annonce->getTitre()} </strong>a bien été supprimée."
            );
            $user=$this->getUser();
            return $this->redirectToRoute('membre_afficher',[
                'slug'=>$user->getSlug()
            ]);
        


        
    }


}