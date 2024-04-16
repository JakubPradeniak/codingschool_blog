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

function getUser(int $id): object {
    global $connection;

    $statement = $connection->prepare('SELECT name, email, role FROM users WHERE id=:id');
    $statement->execute(['id' => $id]);
    return $statement->fetch(PDO::FETCH_OBJ);
}

$user = getUser(1);
echo  json_encode($user);
