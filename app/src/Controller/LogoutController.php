<?php

namespace App\Controller;



use App\Core\Controller\ControllerInterface;
use App\Model\UserModel;
use App\Service\TwigService;

class LogoutController implements ControllerInterface
{

    public function inputRequest(array $tabInput)
    {
    }

    public function outputEvent()
    {
        if(isset($_SESSION["user"])){
            session_unset();
            session_destroy();
        }
        header('Location: /login');
    }
}