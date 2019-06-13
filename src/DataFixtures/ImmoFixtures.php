<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Immo;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Reservation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ImmoFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder=$encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');
        $photo='https://randomuser.me/api/portraits/men/88.jpg';

    //gestion des roles
        $adminRole=new Role();
        $adminRole->setTitre('ROLE_ADMIN');
        $manager->persist($adminRole);
    //Utilisateur admin
    $adminUser=new User;
    $adminUser->setPrenom('Gil')  
              ->setNom('Ortega')
              ->setEmail('ortegagil@gmail.com')
              ->setIntroduction($faker->sentence())
              ->setDescription('<p>'.join('</p><p>',$faker->paragraphs(3)).'</p>')
              ->setHash($this->encoder->encodePassword($adminUser,'password'))
              ->setAvatar($photo)
              ->addUserRole($adminRole);
    $manager->persist($adminUser);

    //gestion des utilisateurs
        $users=[];
        $genres=['male','female'];
        
        for($i=1;$i<=10;$i++){
            $user=new User();

            $genre=$faker->randomElement($genres);
            $photo='https://randomuser.me/api/portraits/';
            $photoId=$faker->numberBetween(1,99).'.jpg';
            $photo=$photo.($genre=='male'?'men/':'women/').$photoId;
            $hash=$this->encoder->encodePassword($user,'password');

            $user->setNom($faker->firstname)
                 ->setPrenom($faker->lastname)
                 ->setEmail($faker->email)
                 ->setIntroduction($faker->sentence())
                 ->setDescription('<p>'.join('</p><p>',$faker->paragraphs(3)).'</p>')
                 ->setHash($hash)
                 ->setAvatar($photo);
            
            $manager->persist($user);
            $users[]=$user;

        }

    //gestion des annonces
        //une annonce à la mano
        $immo= new Immo();
        $immo->setTitre("Titre de l'annonce")
             ->setSlug("titre-de-l-annonce")
             ->setImageLarge("http://placeimg.com/640/480/arch")
             ->setIntroduction("Le plus beau logement sans salle de bains 
             du village")
             ->setContenu("cette merveilleuse datcha contient un merveilleux 
             chateau qui contient un merveilleux gîte dans lequel se trouve un
             appartement dont la chambre est meublée d'une unique poupée russe")
             ->setPrix("200")
             ->setSurface("300")
             ->setSurfaceTerrain("3000")
             ->setProprio($users[1]);
             $manager->persist($immo);
        //19 annonces grace à faker
        for($i=1;$i<=19;$i++){
            $immo= new Immo();

            $titre=$faker->sentence();
            $imagelarge=$faker->imageUrl();
            $introduction=$faker->paragraph(2);
            $contenu='<p>'.join('</p><p>',$faker->paragraphs(4)).'</p>';
            $proprio=$users[mt_rand(0,count($users)-1)];

            $immo->setTitre($titre)
                 ->setImageLarge($imagelarge)
                 ->setIntroduction($introduction)
                 ->setContenu($contenu)
                 ->setPrix(mt_rand(40,200))
                 ->setSurface(mt_rand(50,300))
                 ->setSurfaceTerrain(mt_rand(50,3000))
                 ->setProprio($proprio);

                for($j=1;$j<= mt_rand(2,5);$j++){
                    $image=new Image();

                    $image->setUrl($faker->imageUrl())
                           ->setLegende($faker->sentence())
                           ->setImmo($immo);
                    $manager->persist($image);
                }
            //Gestion des reservations
            for($j=1;$j<= mt_rand(0,10);$j++){
                $reservation=new Reservation();
                $creele=$faker->dateTimeBetween('-6 months');
                $dateentree=$faker->dateTimeBetween('-3 months');
                $duree=mt_rand(3, 10);
                $datesortie=(clone $dateentree)->modify("+$duree days");
                $montant=$immo->getPrix()*$duree;
                $booker=$users[mt_rand(0, count($users)-1)];
                $commentaire=$faker->paragraph();

                $reservation->setBooker($booker)
                            ->setAnnonce($immo)
                            ->setDateentree($dateentree)
                            ->setDatesortie($datesortie)
                            ->setCreele($creele)
                            ->setMontant($montant)
                            ->setCommentaire($commentaire);
                $manager->persist($reservation);
            
            }
             $manager->persist($immo);

        }
        
        

        $manager->flush();
    }
}
