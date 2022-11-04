<?php

namespace App\Form;

use App\Entity\Acteur;
use App\Entity\Film;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ActeurType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder 
        -> add ('nom')
        -> add ('prenom')
        -> add ('date_naissance', BirthdayType::class, [
            'placeholder' => [
                'year' => 'Year', 'month' => 'Month', 'day' => 'Day',]
        ])
        -> add ('date_deces', BirthdayType::class, [
            'required'=>false,
            'placeholder' => [
                'year' => 'Year', 'month' => 'Month', 'day' => 'Day',]
        ])
        -> add('photo', FileType::class, [
            'label' => 'Photo (PDF file)', 
            'data_class'=>null
        ]) 
        ->add('Enregistrer',SubmitType::class);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver-> setDefaults([
            'data_class'=> Acteur::class,
        ]);
    }
}