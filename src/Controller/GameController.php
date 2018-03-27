<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/game")
 */
class GameController extends Controller
{

    /**
     * @Route("/", name="game_home")
     */
    public function game()
    {
        return $this->render('game/game.html.twig');
    }

    /**
     * @Route("/won", name="won")
     */
    public function won()
    {
        return $this->render('game/won.html.twig');
    }

    /**
     * @Route("/failed", name="failed")
     */
    public function failed()
    {
        return $this->render('game/failed.html.twig');
    }

    public function testimonials()
    {
        return $this->render('_testimonials.html.twig', [
            'testimonials' => [
                'John Doe' => 'I love this game, so addictive!',
                'Martin Durand' => 'Best web application ever',
                'Paul Smith' => 'Awesomeness!',
            ],
        ]);
    }
}