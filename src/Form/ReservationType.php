<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReservationType extends AbstractType
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
            ->add('dateentree',DateType::class,[
                'label'=>false,
                'widget'=>'single_text',
                'required' => false
                ])
             
            ->add('datesortie',DateType::class,[
                'label'=>false,
                'widget'=>'single_text',
                'required' => false,
                'attr'=>[
                    'placeholder'=>""                    
                    ]
                ])
            ->add('commentaire',TextareaType::class,$this->conf(false,
            "Si vous avez une demande particulière, ou, si vous désirez laisser un commentaire..."))
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
