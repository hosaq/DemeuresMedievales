<?php

namespace App\Form;

use App\Entity\Immo;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;





class AnnonceType extends AbstractType
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
            ->add('titre',TextType::class,[
                'label'=>'Titre',
                'attr'=>[
                    'placeholder'=>"Entrez le titre de votre annonce"
                    ]
                ])
            ->add('introduction',TextType::class,
                $this->conf("Introduction","Donnez un aperçu \"rapide\" de votre bien. "))
            ->add('contenu',TextareaType::class,
                $this->conf("Contenu","Décrivez avec détails votre location."))
            ->add('imageLarge',UrlType::class,
                $this->conf("Url de l'image principale","Entrez l'Url d'une belle image de votre location."))
            ->add('prix',MoneyType::class,
                $this->conf("Prix par nuit","Indiquez le prix par nuit de votre location."))
            ->add('surface',IntegerType::class,
                $this->conf("Surface","Entrez la surface de votre bien."))
            ->add('surfaceTerrain',IntegerType::class,
                $this->conf("Surface du terrain","Entrez la surface du terrain de votre bien."))
            ->add(
                'images',
                CollectionType::class,
                [
                'entry_type'=>ImageType::class,
                'allow_add'=>true,
                'allow_delete'=>true
                ]
            )
                ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Immo::class,
        ]);
    }
}
