<?php

namespace App\Form;

use App\Entity\Langues;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LanguesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('langue',ChoiceType::class, [
                'placeholder' => 'Choose an option',
                'choices' => [
                    'Arabe' => 'Arabe',
                    'Francais' => 'Francais',
                    'Espagnol'   => 'Espagnol',
                    'Anglais' => 'Anglais',
                    'Russe' => 'Russe',
                    'Chinois' => 'Chinois',
                    'Turc' => 'Turc',
                    'Italien' => 'Italien',
                    'japonais' => 'japonais',
                    'Italien' => 'Italien',
                    'Allemand' => 'Allemand',

                    


                ]
            ])
            ->add('niveau',ChoiceType::class, [
                'placeholder' => 'Choose an option',
                'choices' => [
                    '1' => '1',
                    '2' => '2',
                    '3'   => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',


                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Langues::class,
        ]);
    }
}
