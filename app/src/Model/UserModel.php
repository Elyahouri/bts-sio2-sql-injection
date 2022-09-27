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

    public function authenticate(string $email, string $password){
        $sql = "SELECT * FROM user WHERE email='$email' AND password='$password';";
        //var_dump($sql);
        $query = $this->bdd->query($sql);
        $user = $query->fetch();
        if($user) {
            return new User(intval($user['id']), $user['email'], $user['name'], $user['password']);
        } else {
            return false;
        }

    }

    public function search(string $search): array
    {
        $sql = "SELECT * FROM user WHERE name LIKE '$search'";
        var_dump($sql);
        $query = $this->bdd->query($sql);
        $users = [];
        foreach ($query->fetchAll() as $value)
        {
            $user = new User($value["id"],$value["name"],$value["email"],$value["password"]);
            $users[] = $user;
        }

        return $users;

    }

    public function truncate(){
        $resetRequest = $this->bdd->prepare('TRUNCATE TABLE user');
        $resetRequest->execute();

        $popuplateRequest = $this->bdd->prepare("INSERT INTO `user` (`id`, `email`, `name`, `password`)VALUES (1, 'ela.debonsyeux@mail.dev', 'Ela Debonsyeux', 'password');");
        $popuplateRequest->execute();
    }
}