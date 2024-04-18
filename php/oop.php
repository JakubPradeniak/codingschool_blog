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


class Model
{
    public function __construct(protected PDO $connection)
    {
    }
}


class UserModel extends Model
{
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


$userModel = new UserModel($connection);

$user = $userModel->findOne(1);

if ($user) {
    echo json_encode($user);
}

/*class UkazakaTypeHintinguUTrid
{
    private UserModel $userModel;
}*/