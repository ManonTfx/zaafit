<?php

namespace App\Controller;

use App\Entity\Poids;
use App\Form\PoidsFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PoidsController extends AbstractController
{
    /**
     * @Route("/poids", name="poids")
     */
    public function ajout_poids(Request $request): Response
    {
        $user = $this->getUser();
        $poids = new Poids();

        $form = $this->createForm(PoidsFormType::class, $poids);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $poids->setUser($user);
            // dump(setUtilisateur();
            // dd();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($poids);
            $manager->flush();
            return $this->redirectToRoute('users');
        }

        return $this->render('poids/ajout_poids.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
