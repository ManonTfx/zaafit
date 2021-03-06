<?php

namespace App\Form;

use App\Entity\Poids;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PoidsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user_poids', NumberType::class, array(
                'label' => 'poids.form.register.user_poids.label',
                'attr' => array(
                    'placeholder' => '00.0',
                    'required' => false,

                )
            ))
            ->add('date_jour', DateType::class, [
                'label' => 'poids.form.register.date_jour.label',
                'widget' => 'single_text',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Poids::class,
        ]);
    }
}
