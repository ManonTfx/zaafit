<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\PromoteAdminType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/admin/promote/{id<\d+>}", name="app_promotetoadmin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function promoteToAdmin(Request $request, $id)
    {
        $secret = "PanamCityGang";

        $form = $this->createForm(PromoteAdminType::class);
        $form->handleRequest($request);

        $manager = $this->getDoctrine()->getManager();
        $user = $manager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException("Impossible de trouver l'utilisateur avec l'id : $id");
        }

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get("secret")->getData() != $secret) {
                throw $this->createNotFoundException("Vous n'avez pas le bon mot de passe pour être administrateur");
            }
            $user->setRoles(["ROLE_ADMIN"]);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('security/promote.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}
