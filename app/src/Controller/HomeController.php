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
        if(!isset($_SESSION["user"])){
            header("Location: /login");
        }

        $twig = TwigService::getEnvironment();
        return $twig->render('home/home.html.twig', ["isLogged"=>true]);
    }
}