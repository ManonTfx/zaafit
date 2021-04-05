<?php

namespace App\Controller;

use App\Entity\Food;
use App\Form\FoodUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FoodUserController extends AbstractController
{
    /**
     * @Route("/food/user", name="food_user")
     */
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        $food = new Food();

        $form = $this->createForm(FoodUserType::class, $food);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $food->setUser($user);
            // dump(setUtilisateur();
            // dd();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($food);
            $manager->flush();
            return $this->redirectToRoute('food_user');
        }


        // Get Data Food
        $userDataFood = $this->getUser()->getFood();

        // Transform entity to PHP array
        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        $userHistoricalFood = $serializer->serialize($userDataFood, 'json');
        $userHistoricalFood = json_decode($userHistoricalFood, true);

        $userHistoricalFood = array_slice($userHistoricalFood, 0, 10);


        // $arrayFood = [['Date', 'petit-déjeuner', 'Déjeuner', 'Encas', 'Diner', 'Note journée']];
        // foreach ($userHistoricalFood as $userHistoricalFoods) {
        //     // Get only YYYY-MM-DD
        //     $formatedDate = explode('T', $userHistoricalFoods['date_jour_repas'])[0];

        //     $userPetitDej = $userHistoricalFoods['petit_dejeuner'];
        //     $userDej = $userHistoricalFoods['dejeuner'];
        //     $userEncas = $userHistoricalFoods['encas'];
        //     $userDiner = $userHistoricalFoods['diner'];
        //     $userNote = $userHistoricalFoods['note_journee'];
        //     array_push($arrayFood, [$formatedDate, $userPetitDej, $userDej, $userEncas, $userDiner, $userNote]);
        // }



        return $this->render('users/food_user/foodusers.html.twig', [
            'form' => $form->createView(),
            'userHistoricalFood' => $userHistoricalFood,
            'food' => $food,


        ]);
    }

    /**
     * @Route("/food/modifier/{id<\d+>}", name="app_food_update")
     */
    public function updateFood(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $food = $manager->getRepository(Food::class)->find($id);

        $form = $this->createForm(FoodUserType::class, $food);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($food);
            $manager->flush();

            return $this->redirectToRoute('food_user');
        }

        return $this->render('users/food_user/update.html.twig', [
            'form' => $form->createView(),
            'food' => $food
        ]);
    }

    /**
     * @Route("/food/supprimer/{id<\d+>}", name="app_food_delete")
     */
    public function deleteFood($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $food = $manager->getRepository(Food::class)->find($id);


        $manager->remove($food);
        $manager->flush();

        return $this->redirectToRoute('food_user');
    }
}
