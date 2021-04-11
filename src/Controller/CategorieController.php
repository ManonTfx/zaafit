<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends AbstractController
{
    /**
     * @Route("blog/categorie/creer", name="app_blog_categorie_create")
     * @IsGranted("ROLE_ADMIN")
     */
    public function create(Request $request)
    {
        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($categorie);
            $manager->flush();
        }

        return $this->render('blog/categorie/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("blog/categories", name="app_blog_categorie_showAll")
     */
    public function showall()
    {
        $allCategories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();

        return $this->render('blog/categorie/showAll.html.twig', [
            'allCategories' => $allCategories,
        ]);
    }

    /**
     * @Route("blog/categorie/editer/{id<\d+>}", name="app_blog_categorie_update")
     * @IsGranted("ROLE_ADMIN")
     */
    public function update(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $categorie = $this->getDoctrine()->getRepository(Categorie::class)->find($id);

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($categorie);
            $manager->flush();

            return $this->redirectToRoute('app_blog_categorie_showAll');
        }

        return $this->render('blog/categorie/create.html.twig', [
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("blog/categorie/supprimer/{id<\d+>}", name="app_blog_categorie_delete")
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $categorie = $manager->getRepository(Categorie::class)->find($id);

        $manager->remove($categorie);
        $manager->flush();

        return $this->redirectToRoute('app_blog_categorie_showAll');
    }

    /**
     * @Route("blog/categorie/{id<\d+>}", name="app_blog_categorie")
     */
    public function show($id)
    {

        $allCategories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $categorie = $this->getDoctrine()->getRepository(Categorie::class)->find($id);



        return $this->render('blog/categorie/show.html.twig', [
            'categorie' => $categorie,
            'allcategories' => $allCategories,
        ]);
    }
}
