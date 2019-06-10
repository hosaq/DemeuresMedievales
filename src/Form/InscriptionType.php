<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class InscriptionType extends AbstractType
{

    /**
    * configure le label et placeholder
    * @param string $lab 
    * @param string $place
    * @return array
    */
    private function conf($lab,$place){
        return [
            'label'=>$lab,
            'required' => false,
            'attr'=>[
                'placeholder'=>$place
                ]
            ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,$this->conf('Nom','Votre nom de famille ...'))
            ->add('prenom',TextType::class,$this->conf('Prénom','Votre prénom ...'))
            ->add('email',EmailType::class,$this->conf('Mail','Votre adresse mail ...'))
            ->add('avatar',UrlType::class,$this->conf('Avatar','Url de votre avatar ...'))
            ->add('hash',PasswordType::class,$this->conf('Mot de passe','Chosissez un mot de passe !'))
            ->add('passwordConfirm',PasswordType::class,$this->conf('Confirmation de mot de passe','Confirmez votre mot de passe !'))
            ->add('introduction',TextType::class,$this->conf('Présentation','Décrivez-vous en quelques mots ...'))
            ->add('description',TextareaType::class,$this->conf('Description','Présentez-vous plus longuement ...'))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
