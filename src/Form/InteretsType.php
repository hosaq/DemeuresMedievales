<?php

namespace App\Form;

use App\Entity\Interets;
use App\Entity\Genresinterets;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class InteretsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('lien')
            ->add('genresinterets', EntityType::class, [
                'label' =>'Catégorie',
                'class' =>'App\Entity\Genresinterets',
                'placeholder'=>'Sélectionnez une catégorie',
                'mapped'=> false,
                'required' => false
                    
                ])
            ->add('type1', ChoiceType::class, [
                'label' =>'Type1',
                'required' => false,
                'choices' => [
                    'Festival'=> 'Festival',
                    'Culturels'=>'Culturels' ,
                    'Commerciaux'=>'Commerciaux',
                    'Villes'=>'Villes',
                    'Sportifs'=>'Sportifs',
                    'Paysages'=> 'Paysages',
                    'Autres'=> 'Autres'
                    
                ]
            ])
            
            
            ->add('presentation')
            ->add('description')
            ->add('adresse')   
            ->add('pays')    
            ->add('ville')
            ->add('code_postal')   
            ->add('region')
            ->add('lat')
            ->add('lng')
            ->add('photo1File', FileType::class, [
                'required' => false
            ])
            ->add('photo2File', FileType::class, [
                'required' => false
            ])
            ->add('photo3File', FileType::class, [
                'required' => false
            ])
        ;

        $builder->get('genresinterets')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
               $form=$event->getForm();
               $form->getParent()->add('type2', ChoiceType::class, [
                'label' =>'Type2',
                'required' => false,
                'choices' => [
                    'Festival'=> 'Festival',
                    'Culturels'=>'Culturels' ,
                    'Commerciaux'=>'Commerciaux',
                    'Villes'=>'Villes',
                    'Sportifs'=>'Sportifs',
                    'Paysages'=> 'Paysages',
                    'Autres'=> 'Autres'
                    ]
                ]);
                dump($event->getForm()->getData());
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Interets::class,
        ]);
    }
}