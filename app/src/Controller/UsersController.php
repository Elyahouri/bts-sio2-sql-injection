<?php

namespace App\Controller;



use App\Core\Controller\ControllerInterface;
use App\Model\UserModel;
use App\Service\TwigService;

class UsersController implements ControllerInterface
{
    private $search;

    public function inputRequest(array $tabInput)
    {
        if(isset($tabInput["POST"]["search"])){
            $this->search = $tabInput["POST"]["search"];
        }
    }

    public function outputEvent()
    {
        if(!isset($_SESSION["user"])){
            header("Location: /login");
        }

        $users = [];
        if($this->search){
            $userModel = new userModel();
            $users = $userModel->search($this->search);
        }
        $twig = TwigService::getEnvironment();
        return $twig->render('users/users.html.twig', [
            "users"=>$users,
            "isLogged"=>true
        ]);
    }
}