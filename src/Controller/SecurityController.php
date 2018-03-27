<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\PlayerType;

/**
 * @Route("/game")
 */
class SecurityController extends Controller
{

    /**
     * @Route("/register", name="register", methods={"GET", "POST"})
     */
    public function register(Request $request): Response
    {
        $form = $this->createForm(PlayerType::class)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('success', 'You have been successfully added to the big family of the hangman game!');
            return $this->redirectToRoute('homepage');
        }
        return $this->render('security/register.html.twig', [
            'registration_form' => $form->createView(),
        ]);
    }
}
