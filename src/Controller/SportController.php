<?php

namespace App\Controller;

use App\Entity\Sport;
use App\Form\SportType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SportController extends AbstractController
{
    /**
     * @Route("/sport", name="sport")
     */
    public function index(Request $request): Response
    {

        $user = $this->getUser();
        $sport = new Sport();
        $form = $this->createForm(SportType::class, $sport);


        // Recuperation du poids actuel pour calcul calories
        $poidsUser = $this->getUser()->getPoids();

        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        $userPoids = $serializer->serialize($poidsUser, 'json');
        $userPoids = json_decode($userPoids, true);

        $arrayPoids = [[]];
        foreach ($userPoids as $userHistoricalWeight) {

            $userWeight = floatval($userHistoricalWeight['user_poids']);
            array_push($arrayPoids, [$userWeight]);
        }
        $poidsUser = $userHistoricalWeight['user_poids'];





        $userDataSport = $this->getUser()->getSports();

        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        $userHistoricalSport = $serializer->serialize($userDataSport, 'json');
        $userHistoricalSport = json_decode($userHistoricalSport, true);

        $arraySport = [['Date', 'Type de sport', 'Durée', 'Calories dépensées']];
        foreach ($userHistoricalSport as $userHistoricalSports) {
            // Get only YYYY-MM-DD
            $formatedDate = explode('T', $userHistoricalSports['date_jour_sport'])[0];
            $typeSport = $userHistoricalSports['type_de_sport'];
            $dureeMinutes = $userHistoricalSports['duree_minutes'];
            $weightUser =  $userHistoricalSports['poids_user'];
            $caloriesDepensees =  $userHistoricalSports['calories_depensees'];
            array_push($arraySport, [$formatedDate, $typeSport, $dureeMinutes, $caloriesDepensees]);
        }

        $userHistoricalSport = array_slice($userHistoricalSport, 0, 10);






        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $sport->setUser($user);
            $sport->setPoidsUser($poidsUser);

            $typeSport = $sport->getTypeDeSport();

            // Calcul MET
            if ($typeSport === "Aerobic intensité normale") {
                $met = 5.5;
            } else if ($typeSport === "Aerobic haute intensité" | $typeSport === "Tennis") {
                $met = 7.5;
            } else if ($typeSport === "Aquabiking" | $typeSport === "Course à pied (8km/h)" | $typeSport === "Football" | $typeSport === "Kayak eaux vives" | $typeSport === "Natation /Crawl" | $typeSport === "Zumba" | $typeSport === "Handball") {
                $met = 8;
            } else if ($typeSport === "Aquagym" | $typeSport === "Danse" | $typeSport === "Equitation" | $typeSport === "Fitness intensité faible" | $typeSport === "Gymnastique" | $typeSport === "Volley Ball") {
                $met = 4;
            } else if ($typeSport === "Arts martiaux" | $typeSport === "Aviron intense" | $typeSport === "Escalade" | $typeSport === "Natation /Papillon" | $typeSport === "Step intensité forte") {
                $met = 11;
            } else if ($typeSport === "Aviron modéré" | $typeSport === "Badminton intermediaire" | $typeSport === "Course à pied faible allure" | $typeSport === "Plongée" | $typeSport === "Rameur" | $typeSport === "Ski de fond" | $typeSport === "Ski de fond" | $typeSport === "Step intensité modérée" | $typeSport === "Tennis de table") {
                $met = 7;
            } else if ($typeSport === "Badminton Calme" | $typeSport === "Marche rapide") {
                $met = 4.5;
            } else if ($typeSport === "Badminton intense" | $typeSport === "Karaté" | $typeSport === "Natation /Brasse" | $typeSport === "Judo" | $typeSport === "Rugby") {
                $met = 10;
            } else if ($typeSport === "Basket Ball" | $typeSport === "Fitness intensité moyenne" | $typeSport === "Randonnée") {
                $met = 6;
            } else if ($typeSport === "Boxe modérée" | $typeSport === "Fitness intensité forte" | $typeSport === "VTT") {
                $met = 9;
            } else if ($typeSport === "Boxe intense") {
                $met = 12;
            } else if ($typeSport === "Corde à sauter modérée") {
                $met = 8.5;
            } else if ($typeSport === "Corde à sauter intense") {
                $met = 11.5;
            } else if ($typeSport === "Course à pied (9,5km/h)") {
                $met = 10.5;
            } else if ($typeSport === "Course à pied (13km/h)") {
                $met = 13;
            } else if ($typeSport === "Golf") {
                $met = 5.5;
            } else if ($typeSport === "Marche" | $typeSport === "Musculation" | $typeSport === "Surf" | $typeSport === "Yoga") {
                $met = 3;
            }

            $caloriesMinutes = ($met * 3.5 * $weightUser) / 200;
            $caloriesTotal = round(($caloriesMinutes * $dureeMinutes));

            $sport->setCaloriesDepensees($caloriesTotal);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($sport);
            $manager->flush();
            return $this->redirectToRoute('sport');
        }



        return $this->render('users/sport_user/sport_user.html.twig', [
            'controller_name' => 'SportController',
            'form' => $form->createView(),
            'userHistoricalSport' => $userHistoricalSport,
            'sport' => $sport,
        ]);
    }


    /**
     * @Route("/sport/modifier/{id<\d+>}", name="app_sport_update")
     */
    public function updateSport(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $sport = $manager->getRepository(Sport::class)->find($id);

        $form = $this->createForm(SportType::class, $sport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($sport);
            $manager->flush();

            return $this->redirectToRoute('sport');
        }

        return $this->render('users/sport_user/update.html.twig', [
            'form' => $form->createView(),
            'sport' => $sport
        ]);
    }

    /**
     * @Route("/sport/supprimer/{id<\d+>}", name="app_sport_delete")
     */
    public function deleteSport($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $sport = $manager->getRepository(Sport::class)->find($id);

        // dd($sport);

        $manager->remove($sport);
        $manager->flush();

        return $this->redirectToRoute('sport');
    }
}
