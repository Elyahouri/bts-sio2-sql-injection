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

    public function authenticate(string $email, string $password)
    {
        $sql = "SELECT * FROM user WHERE email='$email' AND password='$password';";
        $request = $this->bdd->query($sql);

        $user = $request->fetch();
        if ($user) {
            return new User(intval($user['id']), $user['email'], $user['name'], $user['password']);
        } else {
            return false;
        }

    }

    public function search(string $search): array
    {
        $sql = "SELECT * FROM user WHERE name LIKE '$search';";
        var_dump($sql);
        $request = $this->bdd->query($sql);
        $users = [];
        foreach ($request->fetchAll() as $value) {
            $user = new User($value["id"], $value["name"], $value["email"], $value["password"]);
            $users[] = $user;
        }

        return $users;

    }

    public function restore()
    {
        $resetRequest = $this->bdd->prepare("
            DROP TABLE IF EXISTS `user`;
            CREATE TABLE IF NOT EXISTS `user`
            (
                `id`       int(11)      NOT NULL AUTO_INCREMENT,
                `email`    varchar(255) NOT NULL,
                `name`     varchar(255) NOT NULL,
                `password` varchar(255) NOT NULL,
                `credit_card_id` int(11) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE = InnoDB
              AUTO_INCREMENT = 5
              DEFAULT CHARSET = utf8mb4
              COLLATE = utf8mb4_unicode_ci;
            
            DROP TABLE IF EXISTS `credit_card_infos`;
            CREATE TABLE IF NOT EXISTS `credit_card_infos` (
             `id` int(11) NOT NULL,
             `name` varchar(255) NOT NULL,
             `numbers` varchar(255) NOT NULL,
             `expiration` varchar(255) NOT NULL,
             `type` varchar(255) NOT NULL,
             `code` varchar(255) NOT NULL,
             PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            
            ALTER TABLE `user` ADD CONSTRAINT `FK_8D93D6497048FD0F` FOREIGN KEY (`credit_card_id`) REFERENCES `credit_card_infos` (`id`);
        ");
        $resetRequest->execute();
        $resetRequest->closeCursor();

        $popuplateRequest = $this->bdd->prepare("
            INSERT INTO `credit_card_infos` (`id`,`name`, `numbers`, `expiration`, `type`, `code`)
            VALUES
                (1,'Mouss Tache','4024007196288236','11/22','Visa','123'),
                (2,'Harry Zona','2542608345904909','04/25','MasterCard','345'),
                (3,'Juda Bricot','2328434434779064','09/24','MasterCard','766');
            
            INSERT INTO `user` (`id`, `email`, `name`, `password`,`credit_card_id`)
            VALUES
                (1, 'admin@mail.dev', 'Admin', 'password',null),
                (2, 'mouss.tache@mail.dev', 'Mouss Tache', 'password',1),
                (3, 'harry.zona@mail.dev', 'Harry Zona', 'password',2),
                (4, 'judas.bricot@mail.dev', 'Juda Bricot', 'password',3);
        ");
        $popuplateRequest->execute();
        $resetRequest->closeCursor();
    }

}