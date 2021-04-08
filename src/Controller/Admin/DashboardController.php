<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Food;
use App\Entity\Poids;
use App\Entity\Sport;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class DashboardController extends AbstractDashboardController
{



    public function __construct(
        UserRepository $userRepository,
        ArticleRepository $articleRepository
    ) {
        $this->UserRepository = $userRepository;
        $this->ArticleRepository = $articleRepository;
    }
    /**
     * @Route("/admin", name="admin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(): Response
    {
        return $this->render(
            'bundles/EasyAdminBundle/welcome.html.twig',
            [
                'countAllUser' => $this->UserRepository->countAllUsers(),
                'countAllArticles' => $this->ArticleRepository->countAllArticles(),


            ]
        );
        // return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Tableau de bord', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Poids', 'fas fa-weight', Poids::class);
        yield MenuItem::linkToCrud('Repas', 'fas fa-hamburger', Food::class);
        yield MenuItem::linkToCrud('Sport', 'fas fa-dumbbell', Sport::class);
        yield MenuItem::linkToCrud('Articles', 'fas fa-laptop', Article::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-archive', Categorie::class);
    }
}
