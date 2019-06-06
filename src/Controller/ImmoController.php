<?php

namespace App\Controller;

use App\Entity\Immo;
use App\Entity\Image;
use App\Form\AnnonceType;
use App\Repository\ImmoRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
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
     */
    public function creer(Request $request, ObjectManager $manager){
        $annonce=new Immo();

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


}
