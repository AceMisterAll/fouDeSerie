<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Serie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('resume')
            ->add('duree')
            ->add('premiereDiffusion')
            ->add('image')
            ->add('genres',
                EntityType::class,
                array(
                    'class' => Genre::class,
                    'choice_label' => 'libelle', // libelle est la propriété de l'entité Genre que l'on veut afficher
                    'multiple' => true, // permet la sélection multiple 
                    //'expanded' => true, // permet l'affichage en checkbox
                    'query_builder' => function ($Genre) {
                        return $Genre->createQueryBuilder('g')
                            ->orderBy('g.libelle', 'ASC');
                    },
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
        ]);
    }
}
