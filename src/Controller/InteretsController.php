<?php

namespace App\Controller;

use App\Entity\Interets;
use App\Form\InteretsType;
use App\Repository\InteretsRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InteretsController extends AbstractController
{




    /**
     * creer un nouveau centre d'interet
     * 
     * @Route("/creer/interet", name="nouvel_interet")
     * @IsGranted("ROLE_USER")
     */
    public function creerInteret(Request $request, ObjectManager $manager){
        $interet=new Interets();

        $form=$this->createForm(InteretsType::class,$interet);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            $interet->setCreateur($this->getUser());
            $manager->persist($interet);
            $manager->flush();
            $this->addFlash(
                'success',
                "Votre annonce <strong>{$interet->getNom()} </strong>a bien été enregistrée."
            );
            return $this->redirectToRoute('ce_lieu',[
                'slug'=>$interet->getSlug()
            ]);
        }


        return $this->render('interets/nouveau.html.twig',[
            'form'=>$form->createView()
        ]);


    }

    /**
     * modifie un centre d'interet
     * 
     * @Route("/lieu/{slug}/editer", name="modifie_interet")
     * @IsGranted("ROLE_USER")
     */
    public function modifierInteret(Request $request, ObjectManager $manager,Interets $interet){
        

        $form=$this->createForm(InteretsType::class,$interet);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            
            $manager->persist($interet);
            $manager->flush();
            $this->addFlash(
                'success',
                "Votre centre d'intérêt <strong>{$interet->getNom()} </strong>a bien été modifié."
            );
            return $this->redirectToRoute('ce_lieu',[
                'slug'=>$interet->getSlug()
            ]);
        }


        return $this->render('interets/modifier.html.twig',[
            'form'=>$form->createView(),
            'loisir' => $interet
        ]);


    }

    /**
     * montre un lieu d'interet
     * @Route("/lieu/{slug}", name="ce_lieu")
     * @return Response
     */
    public function lieu(Interets $lieu)
    {
        return $this->render('interets/lieu.html.twig', [
            'loisir' => $lieu,
        ]);
    }

}