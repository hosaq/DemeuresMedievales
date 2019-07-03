<?php

namespace App\Form;

use App\Entity\Commentaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('note',IntegerType::class,[
                'label'=>"Note sur 5",
                'required' => true,
                'attr'=>[
                    'placeholder'=>"Choisissez une note, soyez positif !",
                    'min'=>0,
                    'max'=>5,
                    'step'=>1,
                    ]
                ])
            ->add('contenu',TextareaType::class,[
                'label'=>"Votre avis / témoignage :",
                'required' => false,
                'attr'=>[
                    'placeholder'=>"N'hésitez pas à être précis mais restez toujours bienveillant."                    
                    ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
