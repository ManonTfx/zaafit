<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfileType;
use PhpParser\Node\Scalar\MagicConst\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Node\Expression\ConstantExpression;

class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index(): Response
    {
        $dateJour = strftime('%A %d %B');
        // $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
            'dateJour' => $dateJour,
            // 'user' => $user,
        ]);
    }

    /**
     * @Route("/users/profil/modification", name="users_profile_edit")
     */
    public function editProfile(Request $request): Response
    {

        $user = $this->getUser();

        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUpdateAt(new \DateTime("now"));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            // dd($user);

            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('users');
        }

        return $this->render('users/editprofile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/users/pass/modification", name="users_pass_edit")
     */
    public function editPass(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();

            $user = $this->getUser();

            // On vérifie si les deux mots de passes sont identiques
            if ($request->request->get('pass') == $request->request->get('pass2')) {
                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('pass')));
                $em->flush();

                $this->addFlash('message', 'Le mot de passe a bien été modifié');
                return $this->redirectToRoute('users');
            } else {
                $this->addFlash('error', 'Les mots de passes ne sont pas identiques');
            }

            $em->persist($user);
            $em->flush();
        }

        return $this->render('users/editpass.html.twig');
    }
}
