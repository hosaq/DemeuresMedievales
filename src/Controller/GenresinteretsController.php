<?php

namespace App\Controller;

use App\Entity\Genresinterets;
use App\Form\GenresinteretsType;
use App\Repository\GenresinteretsRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GenresinteretsController extends AbstractController
{




    /**
     * creer un nouveau genre
     * 
     * @Route("/admin/genreinteret", name="nouveau_genre")
     * @IsGranted("ROLE_ADMIN")
     */
    public function creerGenresinteret(Request $request, ObjectManager $manager){
        $genre=new Genresinterets();

        $form=$this->createForm(GenresinteretsType::class,$genre);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            
            $manager->persist($genre);
            $manager->flush();
            $this->addFlash(
                'success',
                "Le type d'intérêt <strong>{$genre->getNom()} </strong>a bien été enregistrée."
            );
            return $this->redirectToRoute('nouveau_genre');
        }


        return $this->render('interets/nouveaugenre.html.twig',[
            'form'=>$form->createView()
        ]);


    }

    

}