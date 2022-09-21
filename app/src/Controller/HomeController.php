<?php

namespace App\Controller;



use App\Core\Controller\ControllerInterface;
use App\Service\TwigService;

class HomeController implements ControllerInterface
{
    public function inputRequest(array $tabInput)
    {
        // TODO: Implement inputRequest() method.
    }

    public function outputEvent()
    {
        $twig = TwigService::getEnvironment();
        return $twig->render('home/home.html.twig', []);
    }
}