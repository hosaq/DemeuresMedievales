<?php

namespace App\Form;

use App\Entity\Interets;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class InteretsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('lien')
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
            ->add('type2', ChoiceType::class, [
                'label' =>'Type2',
                'required' => false
                
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
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Interets::class,
        ]);
    }
}