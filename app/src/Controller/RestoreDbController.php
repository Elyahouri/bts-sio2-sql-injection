<?php

namespace App\Controller;



use App\Core\Controller\ControllerInterface;
use App\Model\UserModel;
use App\Service\TwigService;

class RestoreDbController implements ControllerInterface
{


    public function inputRequest(array $tabInput)
    {

    }

    public function outputEvent()
    {
        $userModel = new userModel();
        $userModel->restore();
        $targetLocation = "/login";
        if(isset($_SESSION["user"])){
            $targetLocation = "/";
        }
        header("Location: $targetLocation");
    }
}