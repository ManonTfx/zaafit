<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(): Response
    {

        $allCategories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();

        $categoriediet = $this->getDoctrine()->getRepository(Categorie::class)->findOneBy(["nom" => "DIETETIQUE"]);
        $categoriecardio = $this->getDoctrine()->getRepository(Categorie::class)->findOneBy(["nom" => "CARDIO"]);
        $categoriemuscu = $this->getDoctrine()->getRepository(Categorie::class)->findOneBy(["nom" => "MUSCULATION"]);
        $categoriesante = $this->getDoctrine()->getRepository(Categorie::class)->findOneBy(["nom" => "SANTE"]);






        return $this->render('blog/index.html.twig', [
            'categoriesante' => $categoriesante,
            'categoriemuscu' => $categoriemuscu,
            'categoriecardio' => $categoriecardio,
            'categoriediet' => $categoriediet,
            'allcategories' => $allCategories,
        ]);
    }
}
