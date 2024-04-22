<?php

declare(strict_types=1);

namespace App\Models;

use PDO;
use PDOException;
use App\Model;

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
