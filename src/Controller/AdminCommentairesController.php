<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Service\PaginationService;
use App\Repository\CommentaireRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentairesController extends AbstractController
{
    /**
     * @Route("/admin/commentaires/{page<\d+>?1}", name="admin_commentaires")
     */
     
    public function index(CommentaireRepository $repo, $page=1, PaginationService $pagination)
    {
        $pagination->setEntityClass(Commentaire::class)
                    ->setPageactuelle($page)
                    ->setLimit(5);
        return $this->render('admin/commentaires/admincommentaires.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
