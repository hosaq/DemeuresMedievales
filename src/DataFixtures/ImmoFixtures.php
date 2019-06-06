<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Immo;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ImmoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');

        $immo= new Immo();
        $immo->setTitre("Titre de l'annonce")
             ->setSlug("titre-de-l-annonce")
             ->setImageLarge("https://via.placeholder.com/1000x400")
             ->setIntroduction("Le plus beau logement sans salle de bains 
             du village")
             ->setContenu("cette merveilleuse datcha contient un merveilleux 
             chateau qui contient un merveilleux gîte dans lequel se trouve un
             appartement dont la chambre est meublée d'une unique poupée russe")
             ->setPrix("200")
             ->setSurface("300")
             ->setSurfaceTerrain("3000");
             $manager->persist($immo);
        for($i=1;$i<=19;$i++){
            $immo= new Immo();

            $titre=$faker->sentence();
            $imagelarge=$faker->imageUrl(1000,350);
            $introduction=$faker->paragraph(2);
            $contenu='<p>'.join('</p><p>',$faker->paragraphs(4)).'</p>';

            $immo->setTitre($titre)
                 ->setImageLarge($imagelarge)
                 ->setIntroduction($introduction)
                 ->setContenu($contenu)
                 ->setPrix(mt_rand(40,200))
                 ->setSurface(mt_rand(50,300))
                 ->setSurfaceTerrain(mt_rand(50,3000));

                for($j=1;$j<= mt_rand(2,5);$j++){
                    $image=new Image();

                    $image->setUrl($faker->imageUrl())
                           ->setLegende($faker->sentence())
                           ->setImmo($immo);
                    $manager->persist($image);
                }

             $manager->persist($immo);

        }
        
        

        $manager->flush();
    }
}
