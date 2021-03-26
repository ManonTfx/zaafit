<?php

namespace App\Controller;

use App\Entity\Poids;
use App\Entity\User;
use App\Form\EditProfileType;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\LineChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Options\PieChart\PieSlice;
use DateTime;
use PhpParser\Node\Scalar\MagicConst\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Node\Expression\ConstantExpression;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\HttpFoundation\JsonResponse;

class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */

    // private function handleFormatedDate(formatedDate)
    public function index(): Response
    {

        // COURBE DE POIDS
        $chart = new LineChart();

        // Get user historical data
        $userDataWeight = $this->getUser()->getPoidsUser();

        // Transform entity to PHP array
        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        $userHistoricalWeights = $serializer->serialize($userDataWeight, 'json');
        $userHistoricalWeights = json_decode($userHistoricalWeights, true);


        // Get Objectif User
        $objectifUser = $this->getUser()->getObjectifPoids();
        $objectif = round($objectifUser);


        // Add header for graph
        $dataForGraph = [[' ', 'Poids', 'Objectif']];
        // Add historical weight for the user
        foreach ($userHistoricalWeights as $userHistoricalWeight) {
            // Get only YYYY-MM-DD
            $formatedDate = explode('T', $userHistoricalWeight['date_jour'])[0];

            // Transform weight from string to float
            $userWeight = floatval($userHistoricalWeight['user_poids']);
            array_push($dataForGraph, [$formatedDate, $userWeight, $objectif]);
        }


        $chart->getData()->setArrayToDataTable($dataForGraph);

        $chart->getOptions()->setTitle('Evolution Poids');
        $chart->getOptions()->setCurveType('function');
        $chart->getOptions()->setLineWidth(3);
        // $chart->getOptions()->getLegend()->setPosition('none');

        $chart->getOptions()
            ->setFontName('Lato')
            // ->setHeight(400)
            // ->setWidth(1130)
            ->setSeries(['axis' => 'Temps'])
            ->setAxes(['y' => ['label' => 'Poids (Kg)']]);

        //PERCENT OBJECTIF / WEIGHT
        $poidsDepart = $userHistoricalWeights[0]['user_poids'];
        $percent = round(100 * ($poidsDepart - $userWeight) / ($poidsDepart - $objectif));

        //Calcul IMC
        $userWeight = $userHistoricalWeight['user_poids'];
        $userHeight = $this->getUser()->getTailleUser();

        $imc = ($userWeight * 10000) / ($userHeight * $userHeight);

        if ($imc < 16) {
            $resultimc = "Maigreur extrême";
        } else if ($imc < 18.5) {
            $resultimc = "Maigreur";
        } else if ($imc < 24.9) {
            $resultimc = "Poid normal";
        } else if ($imc < 29.9) {
            $resultimc = "Surpoids";
        } else if ($imc < 34.9) {
            $resultimc = "Obésité légère";
        } else if ($imc < 39.9) {
            $resultimc = "Obésité";
        } else if ($imc > 40) {
            $resultimc = "Obésité morbide";
        }





        // Affiche la date et l'heure du jour sur le dashboard
        $dateJour = date('l j F Y, H:i');
        $heure = strftime('%H:%M:%S');
        // $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        return $this->render('users/homeusers.html.twig', [
            'controller_name' => 'UsersController',
            'dateJour' => $dateJour,
            'heure' => $heure,
            'chart' => $chart,
            'imc' => $imc,
            'resultimc' => $resultimc,
            'percent' => $percent,
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
