<?php

namespace App\Controller\Error;

use App\Core\Controller\ControllerInterface;
use App\Core\View\TwigCore;

class HttpController implements ControllerInterface
{

    public function inputRequest(array $tabInput)
    {
        // Nulle :)
    }

    public function outputEvent()
    {
        // Si y a pas de GET alors j'affiche tout
        return TwigCore::getEnvironment()->render(
            'error/http-404.html.twig',
            []);
    }
}