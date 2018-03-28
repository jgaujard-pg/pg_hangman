<?php

namespace App\Controller;

use App\Player\Manager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\PlayerType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/{_locale}", requirements={"_locale"="en|fr|de"})
 */
class SecurityController extends Controller
{

    /**
     * @Route(
     *     "/register",
     *     name="register",
     *     methods={"GET", "POST"}
     *     )
     */
    public function register(Request $request, Manager $manager): Response
    {
        $form = $this->createForm(PlayerType::class)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->register($form->getData());

            $this->addFlash('success', 'You have been successfully added to the big family of the hangman game!');
            return $this->redirectToRoute('homepage');
        }
        return $this->render('security/register.html.twig', [
            'registration_form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/login",
     *     name="login"
     *     )
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('security/login.html.twig', [
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'last_username' => $authenticationUtils->getLastUsername()
        ]);
    }

    /**
     * @Route(
     *     "/logout",
     *     name="logout"
     *     )
     */
    public function logout()
    {
    }
}
