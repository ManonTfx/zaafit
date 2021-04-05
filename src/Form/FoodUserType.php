<?php

namespace App\Form;

use App\Entity\Food;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FoodUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_jour_repas', TypeDateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('petit_dejeuner', null, [
                'required'   => false,
                'empty_data' => ' ',
            ])
            ->add('dejeuner', null, [
                'required'   => false,
                'empty_data' => ' ',
            ])
            ->add('encas', null, [
                'required'   => false,
                'empty_data' => ' ',
            ])
            ->add('diner', null, [
                'required'   => false,
                'empty_data' => ' ',
            ])
            ->add('note_journee', ChoiceType::class, [
                'choices'  => [
                    '😀' => '😀',
                    '😐' => '😐',
                    '😒' => '😒',
                    '🥵' => '🥵',
                ]
            ], null, [
                'required'   => false,
                'empty_data' => ' ',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Food::class,
        ]);
    }
}
