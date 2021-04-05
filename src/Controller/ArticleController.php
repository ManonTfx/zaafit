<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ArticleController extends AbstractController
{
    /**
     * @Route("/blog/article/creer", name="app_blog_article_create")
     * @IsGranted("ROLE_ADMIN")
     */
    public function create(Request $request)
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article
                ->setDateCreation(new \DateTime('now'));

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($article);

            $manager->flush();

            return $this->redirectToRoute('app_blog_article_showAll');
        }

        return $this->render('blog/article/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/blog/articles", name="app_blog_article_showAll")
     */
    public function showAll(): Response
    {
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $allArticles = $this->getDoctrine()->getRepository(Article::class)->findAll();


        return $this->render('blog/article/showAll.html.twig', [
            'allArticles' => $allArticles,
            'categories' => $categories,
        ]);
    }
    /**
     * @Route("/blog/article/{id<\d+>}", name="app_blog_article")
     */
    public function show($id)
    {

        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);



        return $this->render('blog/article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/blog/article/editer/{id<\d+>}", name="app_blog_article_update")
     * @IsGranted("ROLE_ADMIN")
     */
    public function update(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $article = $manager->getRepository(Article::class)->find($id);

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUpdateAt(new \DateTime("now"));

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('app_blog_article_showAll');
        }

        return $this->render('blog/article/create.html.twig', [
            'form' => $form->createView(),
            'article' => $article
        ]);
    }

    /**
     * @Route("/blog/article/supprimer/{id<\d+>}", name="app_blog_article_delete")
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $article = $manager->getRepository(Article::class)->find($id);

        $manager->remove($article);
        $manager->flush();

        return $this->redirectToRoute('app_blog_article_showAll');
    }
}
