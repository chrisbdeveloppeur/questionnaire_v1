<?php

namespace App\Controller;

use App\Form\QuestionnaireUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(QuestionnaireUserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $entityManager->persist($user);
            $entityManager->flush();
            $form->isEmpty();

            $this->addFlash('success', 'Votre compte a bien été créé !');

            return $this->redirectToRoute("home");
        }
        return $this->render('ask_user/index.html.twig', [
            'questionnaire_form' => $form->createView(),
        ]);
    }
}
