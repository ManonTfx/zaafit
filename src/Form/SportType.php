<?php

namespace App\Form;

use App\Entity\Sport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_jour_sport', TypeDateType::class, [
                'widget' => 'single_text',
            ])
            ->add(
                'type_de_sport',
                ChoiceType::class,
                [
                    'choices'  => [
                        'Aerobic intensité normale' => 'Aerobic intensité normale',
                        'Aerobic haute intensité' => 'Aerobic haute intensité',
                        'Aquabiking' => 'Aquabiking',
                        'Aquagym' => 'Aquagym',
                        'Arts martiaux' => 'Arts martiaux',
                        'Aviron modéré' => 'Aviron modéré',
                        'Aviron intense' => 'Aviron intense',
                        'Badminton Calme' => 'Badminton Calme',
                        'Badminton intermediaire' => 'Badminton intermediaire',
                        'Badminton intense' => 'Badminton intense',
                        'Basket Ball' => 'Basket Ball',
                        'Boxe modérée' => 'Boxe modérée',
                        'Boxe intense' => 'Boxe intense',
                        'Corde à sauter modérée' => 'Corde à sauter modérée',
                        'Corde à sauter intense' => 'Corde à sauter intense',
                        'Course à pied faible allure' => 'Course à pied faible allure',
                        'Course à pied (8km/h)' => 'Course à pied (8km/h)',
                        'Course à pied (9,5km/h)' => 'Course à pied (9,5km/h)',
                        'Course à pied (13km/h)' => 'Course à pied (13km/h)',
                        'Danse' => 'Danse',
                        'Equitation' => 'Equitation',
                        'Escalade' => 'Escalade',
                        'Fitness intensité faible' => 'Fitness intensité faible',
                        'Fitness intensité moyenne' => 'Fitness intensité moyenne',
                        'Fitness intensité forte' => 'Fitness intensité forte',
                        'Football' => 'Football',
                        'Golf' => 'Golf',
                        'Gymnastique' => 'Gimnastique',
                        'Handball' => 'Handball',
                        'Judo' => 'Judo',
                        'Karaté' => 'Karaté',
                        'Kayak eaux calmes' => 'Kayak eaux calmes',
                        'Kayak eaux vives' => 'Kayak eaux vives',
                        'Marche' => 'Marche',
                        'Marche rapide' => 'Marche rapide',
                        'Musculation' => 'Muculation',
                        'Natation /Brasse' => 'Natation /Brasse',
                        'Natation /Crawl' => 'Natation /Crawl',
                        'Natation /Papillon' => 'Natation /Papillon',
                        'Plongée' => 'Plongée',
                        'Rameur' => 'Rameur',
                        'Randonnée' => 'Randonnée',
                        'Rugby' => 'Rugby',
                        'Ski alpin' => 'Ski alpin',
                        'Ski de fond' => 'Ski de fond',
                        'Step intensité modérée' => 'Step intensité modérée',
                        'Step intensité forte' => 'Step intensité forte',
                        'Surf' => 'Surf',
                        'Tennis de table' => 'Tennis de table',
                        'Tennis' => 'Tennis',
                        'Volley Ball' => 'Volley Ball',
                        'VTT' => 'VTT',
                        'Yoga' => 'Yoga',
                        'Zumba' => 'Zumba',
                    ]
                ],
            )

            ->add('duree_minutes', NumberType::class, array(
                'attr' => array(
                    'placeholder' => '000',
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sport::class,
        ]);
    }
}
