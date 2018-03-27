<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Game\WordList;
use App\Game\GameContext;
use App\Game\GameRunner;
use App\Game\Loader\TextFileLoader;
use App\Game\Loader\XmlFileLoader;

/**
 * @Route("/{_locale}/game", requirements={"_locale" : "en|fr|de"})
 */
class GameController extends Controller
{

    /**
     * @Route(
     *     "/",
     *     name="game_home"
     * )
     */
    public function game(Request $request)
    {
        $game = $this->createGameRunner(true)->loadGame();

        return $this->render('game/game.html.twig', [
            'game' => $game,
        ]);
    }

    /**
     * @Route("/won", name="won")
     */
    public function won()
    {
        try {
            $game = $this->createGameRunner()->resetGameOnSuccess();
        } catch (\Exception $e) {
            return $this->redirectToRoute('app_game_play');
        }

        return $this->render('game/won.html.twig', ['game' => $game]);
    }

    /**
     * @Route("/failed", name="failed")
     */
    public function failed()
    {
        try {
            $game = $this->createGameRunner()->resetGameOnFailure();
        } catch (\Exception $e) {
            return $this->redirectToRoute('app_game_play');
        }

        return $this->render('game/failed.html.twig', ['game' => $game]);
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

    private function createGameRunner($withWordList = false)
    {
        $wordList = null;
        if ($withWordList) {
            $wordList = new WordList();
            $wordList->addLoader('txt', new TextFileLoader());
            $wordList->addLoader('xml', new XmlFileLoader());
            $wordList->addWord('customer');
            $wordList->addWord('lemonade');
            $wordList->addWord('employee');
            $wordList->loadDictionaries($this->getParameter('dictionaries'));
        }

        return new GameRunner(new GameContext($this->get('session')), $wordList);
    }
}