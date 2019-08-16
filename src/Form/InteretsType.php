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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;



class InteretsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('lien')
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
            ->add('genresinterets', EntityType::class, [
                'label' =>'Catégorie',
                'class' =>'App\Entity\Genresinterets',
                'placeholder'=>'Sélectionnez une catégorie',
                'mapped'=> true,
                'required' => false
                    
                ])
            ->add('type2', EntityType::class, [
                'label' =>'Tag',
                'required' => false,
                'mapped'=> true,
                'class' => 'App\Entity\Tag',
                'placeholder'=>'Sélectionnez un tag',
                ])
            
        ;

        /*$builder->get('genresinterets')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                
                $form=$event->getForm();
                dump($form->getData());
                $form->getParent()
                    ->add('type2', EntityType::class, [
                        'label' =>'Type2',
                        'required' => false,
                        'mapped'=> true,
                        'class' => 'App\Entity\Tag',
                        'choices'=>$form->getData()->getTags()
                        ])
                        
                    ;
                //dump($event->getForm()->getData());
            }
        );*/
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Interets::class,
        ]);
    }
}