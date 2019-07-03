<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\DataTransformer\FrenchToDateTimeTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReservationType extends AbstractType
{
    private $transformer;
    public function __construct(FrenchToDateTimeTransformer $transformer){
        $this->transformer=$transformer;
    }


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
            ->add('dateentree',TextType::class,[
                'label'=>false,
                
                'required' => false,
                'attr'=>[
                    'placeholder'=>"Choisissez une date"                    
                    ]
                ])
             
            ->add('datesortie',TextType::class,[
                'label'=>false,
                
                'required' => false,
                'attr'=>[
                    'placeholder'=>"Choisissez une date"                    
                    ]
                ])
            ->add('commentaire',TextareaType::class,$this->conf(false,
            "Si vous avez une demande particulière, ou, si vous désirez laisser un commentaire..."))
            
            
        ;
        $builder->get('dateentree')->addModelTransformer($this->transformer);
        $builder->get('datesortie')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
