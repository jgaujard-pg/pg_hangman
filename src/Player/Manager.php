<?php

namespace App\Player;

use App\Entity\Player;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Manager
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * Manager constructor.
     * @param ObjectManager $objectManager
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(ObjectManager $objectManager, UserPasswordEncoderInterface $encoder)
    {
        $this->objectManager = $objectManager;
        $this->encoder = $encoder;
    }

    /**
     * @param Player $player
     */
    public function register(Player $player)
    {
        $encodedPassword = $this->encoder->encodePassword($player, $player->getPassword());
        $player->setPassword($encodedPassword);
        $this->objectManager->persist($player);
        $this->objectManager->flush();
    }
}