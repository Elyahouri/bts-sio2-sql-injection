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
        $request = $this->bdd->query($sql);

        $user = $request->fetch();
        if($user) {
            return new User(intval($user['id']), $user['email'], $user['name'], $user['password']);
        } else {
            return false;
        }

    }

    public function search(string $search): array
    {
        $sql = "SELECT * FROM user WHERE name LIKE '$search'";
        $request = $this->bdd->query($sql);
        $users = [];
        foreach ($request->fetchAll() as $value)
        {
            $user = new User($value["id"],$value["name"],$value["email"],$value["password"]);
            $users[] = $user;
        }

        return $users;

    }

    public function restore(){
        $resetRequest = $this->bdd->prepare("
                            DROP TABLE IF EXISTS `user`;
                            CREATE TABLE IF NOT EXISTS `user`
                            (
                                `id`       int(11)      NOT NULL AUTO_INCREMENT,
                                `email`    varchar(255) NOT NULL,
                                `name`     varchar(255) NOT NULL,
                                `password` varchar(255) NOT NULL,
                                PRIMARY KEY (`id`)
                            ) ENGINE = InnoDB
                              AUTO_INCREMENT = 5
                              DEFAULT CHARSET = utf8mb4
                              COLLATE = utf8mb4_unicode_ci;
                           ");
        $resetRequest->execute();
        $resetRequest->closeCursor();

        $popuplateRequest = $this->bdd->prepare("
                                INSERT INTO `user` (`id`, `email`, `name`, `password`)
                                VALUES
                                    (1, 'admin@mail.dev', 'Admin', 'password'),
                                    (2, 'mouss.tache@mail.dev', 'Mouss Tache', 'password'),
                                    (3, 'harry.zona@mail.dev', 'Harry Zona', 'password'),
                                    (4, 'judas.bricot@mail.dev', 'Juda Bricot', 'password');
                             ");
        $popuplateRequest->execute();
        $resetRequest->closeCursor();
    }

}