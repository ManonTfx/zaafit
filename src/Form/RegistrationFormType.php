<?php

namespace App\Form;

use App\Entity\Historique;
use App\Entity\Poids;
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
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passes ne sont pas identiques',
                // 'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => [
                    'attr' => ['placeholder' => 'Mot de passe']
                ],
                'second_options' => [
                    'attr' => ['placeholder' => 'Confirmation du passe']
                ],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('nom', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Nom',

                )
            ))
            ->add('prenom', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Prénom',
                )
            ))
            ->add('sexe', ChoiceType::class, [
                'choices'  => [
                    'Femme' => 'f',
                    'Homme' => 'h',
                ]
            ])
            ->add('imageFile', FileType::class)
            ->add('taille_user', NumberType::class, array(
                'attr' => array(
                    'placeholder' => '000',
                )
            ))

            ->add('objectif_poids', NumberType::class, array(
                'attr' => array(
                    'placeholder' => '00.0',
                )
            ))
            ->add('email', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Adresse mail',
                )
            ))
            ->add('agreeTerms', CheckboxType::class, [
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
