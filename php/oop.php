<?php

declare(strict_types=1);

$connection = new PDO(
    'mysql:dbname=blog;host=127.0.0.1',
    'root',
    '',
    array(
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    )
);

/*
public - k tomuto se dostanu zvenčí
private - nedostaneme se zvenčí a nedostaneme se tomu ani třída, která rozšiřuje
          třídu co implentuje private vlastnost nebo metodu
protected - nedostaneme se zvenčí, ale můžu k dané vlastnosti/metodě přistoupit 
            uvnitř třídy která rozšiřuje třídu co implentuje protected vlastnost nebo metodu
*/

class Model
{
    public function __construct(protected PDO $connection)
    {
    }
}


class UserModel extends Model
{
    // pouze pro demostraci konstruktoru uvnotř třídy, která dědí z jiné třídy
    private object|false $loggedUser;

    public function __construct(PDO $connection, int $loggedUserId)
    {
        parent::__construct($connection);

        $this->loggedUser = $this->findOne($loggedUserId);
    }

    public function findOne(int $id): object|false {
        try {
            $statement = $this->connection->prepare('SELECT * FROM users WHERE id=:id');
            $statement->execute(['id' => $id]);
            return $statement->fetch(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            echo 'Něco se pokazilo.';
            return false;
        }
    }

    public function getLoggedUser(): object|false {
        return $this->loggedUser;
    }
}

class PostModel extends Model
{
    public function findOne(int $id): object|false {
        try {
            $statement = $this->connection->prepare('SELECT * FROM posts WHERE id=:id');
            $statement->execute(['id' => $id]);
            return $statement->fetch(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            echo 'Něco se pokazilo.';
            return false;
        }
    }
}


$userModel = new UserModel($connection, 1);

$user = $userModel->findOne(1);
$loggedUser = $userModel->getLoggedUser();

if ($user) {
    echo json_encode($user);
}

echo "<br>";
echo json_encode($loggedUser);

/*class UkazakaTypeHintinguUTrid
{
    private UserModel $userModel;
}*/