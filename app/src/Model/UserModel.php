<?php

namespace App\Model;

use App\Core\Service\DatabaseService;
use App\Entity\User;
use PDO;

class UserModel
{
    private PDO $bdd;

    public function __construct()
    {
        $this->bdd = DatabaseService::getConnect();
    }

    public function fetchAll(): array
    {
        $request = $this->bdd->prepare('SELECT * FROM user');
        $request->execute();
        $commentsArray = [];

        foreach ($request->fetchAll() as $value)
        {
            $user = new User($value["id"],$value["name"],$value["email"],$value["password"]);
            $usersArray[] = $user;
        }

        return $usersArray;

    }

    public function create(User $user): void
    {
        $request = $this->bdd->prepare('INSERT INTO user(email,name, password) VALUES(:email, :name, :password)');
        $request->execute(['email'=>$user->getEmail(),'name' => $user->getName(), 'password' => $user->getPassword()]);
    }

    public function truncate(){
        $resetRequest = $this->bdd->prepare('TRUNCATE TABLE user');
        $resetRequest->execute();

        $popuplateRequest = $this->bdd->prepare("INSERT INTO `user` (`id`, `email`, `name`, `password`)VALUES (1, 'ela.debonsyeux@mail.dev', 'Ela Debonsyeux', 'password');");
        $popuplateRequest->execute();
    }
}