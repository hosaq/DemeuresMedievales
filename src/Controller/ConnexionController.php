<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use App\Form\NouveauMdpType;
use App\Form\InscriptionType;
use App\Entity\ModificationMdp;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ConnexionController extends AbstractController
{
    /**
     * Connexion
     * @Route("/connexion", name="connexion_login")
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error=$utils->getLastAuthenticationError();
        $username=$utils->getLastUsername();
        return $this->render('connexion/login.html.twig',[
            'hasError'=> $error!==null,
            'username'=>$username
        ]);
    }

    /**
     * Deconnexion
     * @Route("/deconnexion", name="connexion_logout")
     * @IsGranted("ROLE_USER")
     * @return void
     */
    public function logout()
    {
       
    }

    /**
     * Affiche le formulaire d'inscription
     * @Route("/inscription", name="connexion_enregistrer")
     * @return Response
     */
    public function inscription(Request $request,ObjectManager $manager,
    UserPasswordEncoderInterface $encoder )
    {
        $user=new User();
        $form=$this->createForm(InscriptionType::class,$user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $hash=$encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);

            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success','Votre compte a bien été créé, vous pouvez
            maintenant vous connecter !'
            );
            return $this->redirectToRoute('connexion_login');
        }
        return $this->render('connexion/inscription.html.twig',[
            'form'=> $form->createView()
            
        ]);
    }

    /**
     * Affiche le formulaire d'inscription pour modification
     * @Route("/modifier/profil", name="modifier_compte")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function modificationCompte(Request $request,ObjectManager $manager)
    {
        $user=$this->getUser();
        $form=$this->createForm(ProfileType::class,$user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success','Votre compte a bien été modifié !'
            );
            return $this->redirectToRoute('membre_afficher',['slug' => $user->getSlug()]);
        }
        return $this->render('connexion/modifierprofil.html.twig',[
            'form'=> $form->createView()
            
        ]);
    }

    /**
     * modification du mot de passe
     * @Route("/modifier/mdp", name="modification_mdp")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function modifierMdp(Request $request,ObjectManager $manager,
    UserPasswordEncoderInterface $encoder)
    {
        
        $user=$this->getUser();
        if( !$user){
            return $this->redirectToRoute('connexion_login');
        }
        $modificationmdp=new ModificationMdp();
        $form=$this->createForm(NouveauMdpType::class,$modificationmdp);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if(!password_verify($modificationmdp->getAncienmdp(),$user->getHash())){
                $form->get('ancienmdp')->addError(new FormError("Le mot de passe que vous avez 
                tapé n'est pas votre mot de passe actuel"));
            }else{
                $nouveaumdp=$modificationmdp->getNouveaumdp();
                $hash=$encoder->encodePassword($user,$nouveaumdp);
                $user->setHash($hash);
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('success','Votre nouveau mot de passe a bien été modifié !'
                );
                return $this->redirectToRoute('membre_afficher',['slug' => $user->getSlug()]);
            }
            
            
        }
        return $this->render('connexion/modifiermdp.html.twig',[
            'form'=> $form->createView()
            
        ]);
    }
}
