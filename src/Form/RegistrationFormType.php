<?php

namespace App\Form;

use App\Entity\Historique;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array(
                'label' => 'user.form.register.nom.label',
                'attr' => array(
                    'placeholder' => 'Nom',

                )
            ))
            ->add('prenom', TextType::class, array(
                'label' => 'user.form.register.prenom.label',
                'attr' => array(
                    'placeholder' => 'Prénom',
                )
            ))
            ->add('sexe', ChoiceType::class, [
                'label' => 'user.form.register.sexe.label',
                'choices'  => [
                    'Femme' => 'f',
                    'Homme' => 'h',
                ]
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'user.form.register.imageFile.label',
            ])
            ->add('taille_user', NumberType::class, array(
                'label' => 'user.form.register.taille_user.label',
                'attr' => array(
                    'placeholder' => '000',
                )
            ))

            ->add('objectif_poids', NumberType::class, array(
                'label' => 'user.form.register.objectif_poids.label',
                'attr' => array(
                    'placeholder' => '00.0',
                )
            ))
            ->add('email', TextType::class, array(
                'label' => 'user.form.register.email.label',
                'attr' => array(
                    'placeholder' => 'Adresse mail',
                )
            ))
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'user.form.register.agreeTerms.label',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions générales',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
