<?php

namespace App\Form;

use App\Entity\Parcours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ParcoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('post')
            ->add('emplacement')
            ->add('projet')

            ->add('description',TextareaType::class, [
                'attr' => ['rows' => '6'],
            ])
            ->add('mission',TextareaType::class, [
                'attr' => ['rows' => '6'],
            ])
            ->add('technologies')
            ->add('dateDebut',DateType::class)
            ->add('datefin',DateType::class)



           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Parcours::class,
        ]);
    }
}
