<?php
namespace App\Controller;

use App\Repository\ImmoRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController{
    /**
     * Undocumented function
     *
     * @Route("/",name="homepage")
     */
   public function home(ImmoRepository $immoRepo,UserRepository $userRepo){
       return $this->render(
           'home.html.twig',
           [
               'annonces'=>$immoRepo->bonsGites(),
               'proprios'=>$userRepo->bonsLoueurs(2)
           ]
       );

   } 
}
?>