<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class NouveauMdpType extends AbstractType
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
        ->add('ancienmdp',PasswordType::class,$this->conf('Votre mot de passe actuel','Entrez votre mot de passe actuel.'))
        ->add('nouveaumdp',PasswordType::class,$this->conf('Nouveau mot de passe','Chosissez un nouveau mot de passe !'))
        ->add('confirmmdp',PasswordType::class,$this->conf('Confirmation de mot de passe','Confirmez votre nouveau mot de passe.'))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
