<?php

namespace App\Controller;

use App\Service\StatsService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTableaudebordController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_tableaudebord")
     */
    public function index(ObjectManager $manager,StatsService $statsservice)
    {
        

        $stats=$statsservice->getStats();

        $meilleures=$statsservice->getLesplus('DESC');
        
        $pires=$statsservice->getLesplus('ASC');
        

        return $this->render('admin/tableaudebord/tableaubord.html.twig', [
            'stats' => $stats,
            'meilleures'=>$meilleures,
            'pires'=>$pires
        ]);
    }
}
