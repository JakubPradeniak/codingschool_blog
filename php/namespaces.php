<?php

declare(strict_types=1);

require 'App/autoloader.php';

use App\Models\UserModel;


$connection = new PDO(
    'mysql:dbname=blog;host=127.0.0.1',
    'root',
    '',
    array(
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    )
);

$userModel = new UserModel($connection);

$user = $userModel->findOne(1);

if ($user) {
    echo json_encode($user);
}
