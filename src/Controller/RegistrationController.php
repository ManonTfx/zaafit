<?php

namespace App\Controller;

use App\Entity\Historique;
use App\Entity\Poids;
use App\Entity\User;
use App\Form\PoidsFormType;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Date;
use UserBundle\Form\RegisterForm;
use UserBundle\Form\RegisterFormType;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $poids = new Poids();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $poidsUser = $request->request->get("poids_user", "00");


        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->addPoid($poids);
            $poids->setDateJour(new \DateTime('now'));
            // $poids->setUserPoids(
            //     $form->get('poids_user')->getData()
            // );
            $poids->setUserPoids(
                $poidsUser
            );


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->persist($poids);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
