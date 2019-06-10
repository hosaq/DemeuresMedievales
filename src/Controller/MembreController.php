<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
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
}
