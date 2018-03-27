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
 * @Route("/game", requirements={"_locale"="en|fr"})
 */
class GameController extends Controller
{

    /**
     * @Route(
     *     "/",
     *     name="game_home"
     * )
     */
    public function game(GameRunner $runner)
    {
        $game = $runner->loadGame();
        return $this->render('game/game.html.twig', [
            'game' => $game,
        ]);
    }

    /**
     * @Route("/won", name="app_game_win")
     */
    public function won(GameRunner $runner)
    {
        $game = $runner->loadGame();
        try {
            $runner->resetGameOnSuccess();
        } catch (\Exception $e) {
            return $this->redirectToRoute('game_home');
        }

        return $this->render('game/won.html.twig', ['game' => $game]);
    }

    /**
     * @Route("/failed", name="app_game_fail")
     */
    public function failed(GameRunner $runner)
    {
        $game = $runner->loadGame();
        try {
            $runner->resetGameOnFailure();
        } catch (\Exception $e) {
            return $this->redirectToRoute('game_home');
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

    /**
     * This action resets the current game and starts a new one.
     *
     * @Route("/reset", name="app_game_reset", methods="GET")
     */
    public function resetAction(GameRunner $runner)
    {
        $game =
        $runner->resetGame();

        return $this->redirectToRoute('game_home');
    }

    /**
     * This action tries one single letter at a time.
     *
     * @Route("/play/{letter}", name="app_game_play_letter", requirements={"letter"="[a-z]"}, methods="GET")
     */
    public function playLetterAction(GameRunner $runner, $letter)
    {
        $game = $runner->loadGame();
        $runner->playLetter($letter);

        if (!$game->isOver()) {
            return $this->redirectToRoute('game_home');
        }

        return $this->redirectToRoute($game->isWon() ? 'app_game_win' : 'app_game_fail');
    }

    /**
     * This action tries one single word at a time.
     *
     * @Route(
     *   path="/play",
     *   name="app_game_play_word",
     *   condition="request.request.get('word') matches '/^[a-z]+$/i'",
     *   methods="POST"
     * )
     */
    public function playWordAction(Request $request, GameRunner $runner)
    {
        $game = $runner->loadGame();
        $runner->playWord($request->request->get('word'));

        return $this->redirectToRoute($game->isWon() ? 'app_game_win' : 'app_game_fail');
    }

    private function createGameRunner($withWordList = false)
    {
        /*
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
        */
    }
}