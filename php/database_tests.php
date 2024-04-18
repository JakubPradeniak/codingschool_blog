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
Role:
0 - běžný uživatel
1 - admin (nemůže měnit nastavní uživatelů)
2 - superadmin (může měnit vše)
*/

/*$statement = $connection->prepare('INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)');
$statement->execute([
    'name' => 'Jakub',
    'email' => 'jpradeniak@gmail.com',
    'password' => password_hash('123456789', PASSWORD_BCRYPT),
    'role' => 2
]);*/

function createUser(): void {
    global $connection;

    $statement = $connection->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
    $statement->execute([
        'name' => 'Tomáš',
        'email' => 'tom@super-email.com',
        'password' => password_hash('123456789', PASSWORD_BCRYPT),
    ]);
}

function deleteUser(): void {
    global $connection;

    $statement = $connection->prepare('DELETE FROM users WHERE id=:id');
    $statement->execute(['id' => 3]);
}

function createCategory(string $name, string $slug): void {
    global $connection;

    $statement = $connection->prepare('INSERT INTO categories (name, slug) VALUES (:name, :slug)');
    $statement->execute([
        'name' => $name,
        'slug' => $slug
    ]);
}

function updateCategory(string $name, string $slug, int $id): void {
    global $connection;

    $statement = $connection->prepare('UPDATE categories SET name=:name, slug=:slug WHERE id=:id');
    $statement->execute([
        'name' => $name,
        'slug' => $slug,
        'id' => $id
    ]);
}

function getUser(int $id): object|false {
    global $connection;

    try {
        $statement = $connection->prepare('SELECT name, email, role FROM users WHERE id>=:id ORDER BY name ASC, id DESC LIMIT 15');
        $statement->execute(['id' => $id]);
        return $statement->fetch(PDO::FETCH_OBJ);
    } catch(PDOException $e) {
        //echo 'Něco se pokazilo.';
        echo '<pre>';
        var_dump($e);
        echo '</pre>';
        return false;
    }
}

function getPost(int $id): object|false {
    global $connection;

    try {
        $statement = $connection->preprare(
            'SELECT posts.*, users.name AS author_name, categories.name AS category_name FROM posts JOIN users ON posts.author=users.id JOIN categories ON posts.category=categories.id WHERE posts.id=:id'
        );
        $statement->execute(['id' => $id]);
        return $statement->fetch(PDO::FETCH_OBJ);
    } catch(PDOException $e) {
        echo 'Něco se pokazilo.';
        return false;
    }
}


$user = getUser(1);

if ($user) {
    echo json_encode($user);
}
