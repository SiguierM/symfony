<?php

namespace App\Form;

use App\Entity\Acteur;
use App\Entity\Film;
use App\Entity\Genre;
use PhpParser\Parser\Multiple;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('resume')
            ->add('annee_sortie',BirthdayType::class,[
                'label' => 'Jour de sortie'
            ])
            -> add('affiche', FileType::class, [
                'label' => 'Photo',
                'required'=>false, 
                'data_class'=>null
           ])
            ->add('acteurs',EntityType::class,[
                    'class'=>Acteur::class,
                    'choice_label'=>'nom',
                    'required'=>false,
                    'multiple' => true,
                    'expanded' => true,
            ])
            ->add('genre',EntityType::class,[
                'class'=>Genre::class,
                'choice_label'=>'categorie',
                'required'=>false
            ])
            ->add('Enregistrer',SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }
}
