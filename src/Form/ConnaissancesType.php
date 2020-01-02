<?php

namespace App\Form;

use App\Entity\Connaissances;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ConnaissancesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',ChoiceType::class, [
                'placeholder' => 'Choose an option',
                'choices' => [
                    'Conception' => 'choice1',
                    'BDD et Cache' => 'choice2',
                    'Développement' => 'choice3',

                    'Méthodologies'   => 'choice4',
                    'Outils de développement' => 'choice5',
                    'Intégratrion continue' => 'choice6',
                    'Serveurs d application' => 'choice7',
                    'Systémes' => 'choice8',



                ]
            ])
            ->add('technologies')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Connaissances::class,
        ]);
    }
}
