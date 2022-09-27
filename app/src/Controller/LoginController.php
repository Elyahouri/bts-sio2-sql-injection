<?php

namespace App\Controller;



use App\Core\Controller\ControllerInterface;
use App\Model\UserModel;
use App\Service\TwigService;

class LoginController implements ControllerInterface
{
    private $email;
    private $password;
    private $submitted = false;
    private $errors = false;

    public function inputRequest(array $tabInput)
    {
        if(isset($tabInput["POST"]["email"])){
            $this->email = $tabInput["POST"]["email"];
        }
        if(isset($tabInput["POST"]["password"])){
            $this->password = $tabInput["POST"]["password"];
        }
        if(isset($tabInput["POST"]["submit"])){
            $this->submitted = true;
        }
    }

    public function outputEvent()
    {
        $user = null;
        if($this->submitted){
            if($this->email && $this->password && $this->email !== "" && $this->password !== "" ){
                $userModel = new userModel();
                $user = $userModel->authenticate($this->email, $this->password);
                if($user){
                    $_SESSION["user"] = $user->getEmail();
                    header('Location: /users');
                }else{
                    $this->errors = true;
                }
            }else{
                $this->errors = true;
            }
        }

        $twig = TwigService::getEnvironment();
        return $twig->render('login/login.html.twig', [
            "email"=>$this->email,
            "password"=>$this->password,
            "errors"=>$this->errors
        ]);
    }
}